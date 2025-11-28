<section class="mb-4">

    <h4>Delete Account</h4>

    <p class="text-muted">
        Once your account is deleted, all of its resources and data will be permanently removed.
        Please download any data you want to keep before deleting your account.
    </p>

    <!-- Delete Button -->
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeletionModal">
        Delete Account
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeletionModal" tabindex="-1" aria-labelledby="confirmDeletionModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="confirmDeletionModalLabel">Confirm Account Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="modal-body">

                <p>
                    Once your account is deleted, all your resources and data will be permanently removed.
                    Please enter your password to confirm.
                </p>

                <div class="mb-3">
                    <label for="delete_password" class="form-label">Password</label>
                    <input type="password" name="password" id="delete_password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete Account</button>
            </div>

          </form>

        </div>
      </div>
    </div>

</section>
