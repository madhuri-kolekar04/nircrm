@extends('admin.admin_master')

@section('page-title', 'AI Assistant')

@section('admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-robot mr-2"></i>AI Assistant</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="chat-container" style="height: 500px; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                                <div class="chat-header bg-light p-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-robot text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="mb-0">AI Assistant</h6>
                                            <small class="text-muted">Always here to help</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-messages p-3" style="height: 380px; overflow-y: auto; background: #f8f9fa;">
                                    <div class="message bot-message mb-3">
                                        <div class="d-flex">
                                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                                <i class="fas fa-robot text-white" style="font-size: 12px;"></i>
                                            </div>
                                            <div class="ml-2 bg-white p-3 rounded" style="max-width: 80%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                <p class="mb-0">Hello! I'm your AI assistant. How can I help you today?</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-input p-3 border-top bg-white">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type your message..." id="aiMessageInput">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="aiSendBtn">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.message {
    animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.user-message .bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#aiMessageInput').on('keypress', function(e) {
        if (e.which === 13) {
            $('#aiSendBtn').click();
        }
    });

    $('#aiSendBtn').on('click', function() {
        const message = $('#aiMessageInput').val().trim();
        if (message) {
            // Add user message
            const userMessageHtml = `
                <div class="message user-message mb-3">
                    <div class="d-flex justify-content-end">
                        <div class="mr-2 bg-primary text-white p-3 rounded" style="max-width: 80%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <p class="mb-0">${message}</p>
                        </div>
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                        </div>
                    </div>
                </div>
            `;
            $('.chat-messages').append(userMessageHtml);
            $('#aiMessageInput').val('');
            
            // Scroll to bottom
            $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);

            // Simulate AI response (replace with actual API call)
            setTimeout(function() {
                const botMessageHtml = `
                    <div class="message bot-message mb-3">
                        <div class="d-flex">
                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fas fa-robot text-white" style="font-size: 12px;"></i>
                            </div>
                            <div class="ml-2 bg-white p-3 rounded" style="max-width: 80%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <p class="mb-0">Thank you for your message. This is a placeholder response. The AI integration will be implemented soon.</p>
                            </div>
                        </div>
                    </div>
                `;
                $('.chat-messages').append(botMessageHtml);
                $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
            }, 1000);
        }
    });
});
</script>
@endpush

@endsection
