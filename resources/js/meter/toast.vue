<template>
  <div
      class="toast-container position-fixed bottom-0 end-0 p-3"
      style="z-index: 1050"
    >
      <div
        class="toast"
        :class="{ 'bg-success text-white': isSuccess, 'bg-danger text-white': !isSuccess }"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        ref="toast"
      >
        <div class="toast-header">
          <strong class="me-auto">Notification</strong>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="toast"
            aria-label="Close"
          ></button>
        </div>
        <div class="toast-body">{{ toastMessage }}</div>
      </div>
    </div>
</template>


