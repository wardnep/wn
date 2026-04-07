<form id="excludeSession" method="GET" action="{{ url('journey/summary_tp') }}">
    @csrf
    <b>
        Exclude
        <input type="checkbox" name="exclude_asia" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_asia == 'Y' ? 'checked' : '' }} /> Asia
        <input type="checkbox" name="exclude_london" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_london == 'Y' ? 'checked' : '' }} /> London
        <input type="checkbox" name="exclude_london_ny" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_london_ny == 'Y' ? 'checked' : '' }} /> London & NY
        <input type="checkbox" name="exclude_ny" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_ny == 'Y' ? 'checked' : '' }} /> NY<br />
    </b>
</form>
<iframe src="{{ url("journey/summary_tp1/$exclude_asia/$exclude_london/$exclude_london_ny/$exclude_ny") }}" frameborder="0" height="200px;" width="100%"></iframe>
<iframe src="{{ url("journey/summary_tp2/$exclude_asia/$exclude_london/$exclude_london_ny/$exclude_ny") }}" frameborder="0" height="200px;" width="100%"></iframe>
