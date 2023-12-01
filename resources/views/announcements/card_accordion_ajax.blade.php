{!! $announcement->content !!}
<br>
<label>Date Published:</label>
{{ date('F d, Y h:i A', strtotime($announcement->created_at)) }}