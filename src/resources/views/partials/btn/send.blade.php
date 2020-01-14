{{ Form::open(['url' => $url, 'method' => 'post', 'id' => 'formSend' . substr($url, -1)]) }}
<a href="" class="js-submit dropdown-item">
    <i class="dropdown-icon icon fe-send"></i> Testar
</a>
{{ Form::close() }}
