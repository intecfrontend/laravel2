<x-layout>
    <div class="container container--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a new Avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input name="avatar" required type="file">
                @error('avatar')
                <p class="alert small alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</x-layout>

