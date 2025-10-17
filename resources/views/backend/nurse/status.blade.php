    <style>
        .custom-cancel-btn {
            border-radius: 4px;
            /* Subtle rounding */
            padding: 6px 18px;
            /* Balanced size */
            font-weight: 500;
            /* Optional: slightly bolder text */
            border-width: 2px;
            /* Slightly thicker border */
            text-transform: capitalize;
            /* Optional: match font style in image */
        }

        .custom-cancel-btn:hover {
            background-color: rgba(255, 0, 0, 0.06);
            /* Subtle red hover effect */
            color: red;
        }
    </style>

    <div class="modal fade" id="status{{ $nurse->id }}" tabindex="-1" aria-labelledby="statusLabel" aria-hidden="true">
        <form
            action="{{ $nurse->is_activated ? route('admin.nurse.deactivate', $nurse->id) : route('admin.nurse.activate', $nurse->id) }}"
            method="POST">
            @csrf
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-2 py-3 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                        <p class="text-muted font-size-16 mb-4">
                            {{ $nurse->is_activated
                                ? "Are you sure you want to deactivate Dr. {$nurse->user->name}?"
                                : "Are you sure you want to activate Dr. {$nurse->user->name}?" }}
                        </p>

                        <div class="d-flex justify-content-center gap-2">
                            <button type="submit" style="width: 100px;"
                                class="btn btn-{{ $nurse->is_activated ? 'danger' : 'secondary' }}">
                                {{ $nurse->is_activated ? 'Deactivate' : 'Activate' }}
                            </button>

                            <button type="button" class="btn btn-outline-danger custom-cancel-btn"
                                style="width: 100px;" data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
