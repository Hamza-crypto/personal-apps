<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Billed Reading Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white text-center">
                        <h3>Last Billed Reading Form</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store-last-billed-reading') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="meter_name" class="form-label">Meter Name:</label>
                                <select name="meter_name" id="meter_name" class="form-select" required>
                                    <option value="meter1">Meter 1</option>
                                    <option value="meter2">Meter 2</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="reading_value" class="form-label">Reading Value:</label>
                                <input type="number" name="reading_value" id="reading_value" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
