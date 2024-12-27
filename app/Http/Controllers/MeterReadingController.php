<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use App\Models\LastBilledReading;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MeterReadingController extends Controller
{
    public function showLastBilledReadingForm()
    {
        return view('meter_readings.set_reading');
    }

    public function storeLastBilledReading(Request $request, $id)
    {
        LastBilledReading::updateOrCreate(
            ['meter_name' => $id],
            ['reading_value' => $request->input('reading_value')]
        );

        return response()->json(['success' => true, 'message' => 'Last billed reading updated successfully.']);
    }

    public function showMeterReadingForm()
    {
        return view('meter_readings.index');
    }

    public function storeMeterReading(Request $request)
    {
        $validated = $request->validate([
            'meter_name' => 'required|string|in:meter1,meter2',
            'reading_value' => 'required|numeric',
        ]);

        $today = Carbon::now()->startOfDay();

        // Find the existing record for today, if it exists
        $existingReading = MeterReading::where('meter_name', $validated['meter_name'])
            ->whereDate('created_at', $today)
            ->first();

        if ($existingReading) {
            // Update the existing record
            $existingReading->reading_value = $validated['reading_value'];
            $existingReading->save();
        } else {
            // Create a new record
            MeterReading::create([
                'meter_name' => $validated['meter_name'],
                'reading_value' => $validated['reading_value'],
                'created_at' => $today,
            ]);
        }

        return redirect()->route('electricity-graph')->with('success', 'Meter reading updated successfully.');
    }

    public function getLastMonthReading($meter_name)
    {
        return LastBilledReading::where('meter_name', $meter_name)->value('reading_value');
    }

    // public function getTotalReading($meter_name)
    // {
    //     $meterReading = MeterReading::where('meter_name', $meter_name)
    //         ->orderBy('created_at', 'desc')
    //         ->take(10)
    //         ->get();



    //     $meterData = $this->calculateDailyUsage($meterReading, $lastMonthReading);

    //     return array_sum(array_column($meterData, 'usage'));
    // }

    private function calculateDailyUsage($readings, $lastBilledReading)
    {
        $data = [];
        $previousReading = $lastBilledReading;

        foreach ($readings as $reading) {
            $date = Carbon::parse($reading->created_at)->format('Y-m-d');
            $dailyUsage = $reading->reading_value - $previousReading;

            $data[] = [
                'date' => $date,
                'usage' => $dailyUsage,
            ];

            $previousReading = $reading->reading_value;
        }

        return $data;
    }

    public function getMeterReadings($meterName)
    {
        $last_month_reading = $this->getLastMonthReading($meterName);
        $recent_reading = MeterReading::where('meter_name', $meterName)->first();

        $final_reading = $recent_reading->reading_value - $last_month_reading;
        return $final_reading;
        // Get all readings from 27th of previous month and current month
        $readings = MeterReading::where('meter_name', $meterName)
            ->latest()
            ->take(10) // Limit to 30 entries
            ->get()
            ->toArray(); // Convert to array if needed

        $data = [];
        $previousValue = null;

        foreach ($readings as $reading) {
            $difference = $previousValue !== null ? $reading['reading_value'] - $previousValue : null;
            $data[] = [
                'id' => $reading['id'],
                'created_at' => $reading['created_at'],
                'reading_value' => $reading['reading_value'],
                'difference' => $difference
            ];
            $previousValue = $reading['reading_value'];
        }



        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'reading_value' => 'required|numeric',
        ]);

        // Find the meter reading by meter_name (or $id if that's the primary key)
        $meterReading = MeterReading::where('meter_name', $id)->latest()->first();

        // Update the meter reading
        $meterReading->update([
            'reading_value' => $request->input('reading_value'),
        ]);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Meter reading updated successfully!']);
    }

    public function destroy($id)
    {
        $reading = MeterReading::findOrFail($id);
        $reading->delete();
        return redirect()->back()->with('success', 'Meter reading deleted successfully.');
    }


    public function stats()
    {
        $all_meters = LastBilledReading::getMeters();
        $data = [];
        foreach ($all_meters as $key => $name) {

            $last_month_reading = $this->getLastMonthReading($key);
            $recent_reading = MeterReading::where('meter_name', $key)->latest()->first();

            $final_reading = $recent_reading->reading_value ?? 0 - $last_month_reading;

            $data[] = [
                'meter_name' => $key,
                'label' => $name,
                'reading' => $final_reading,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}