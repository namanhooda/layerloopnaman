
<div class="container mt-5">
    <h2>Send WhatsApp Message</h2>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('whatsapp.send') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="number" class="form-label">Phone Number (include country code)</label>
            <input type="text" name="number" class="form-control" id="number" placeholder="911234567890" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" class="form-control" id="message" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Send Message</button>
    </form>
</div>
