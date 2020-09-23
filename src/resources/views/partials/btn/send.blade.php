<form action="{{ $url }}" method="POST" class="send" id="formSend{{ md5($url) }}">
    @csrf
    <a href="#" class="js-submit dropdown-item">
        <i class="dropdown-icon icon fe-send"></i> Testar
    </a>
</form>