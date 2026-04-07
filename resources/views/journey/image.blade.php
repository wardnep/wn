<html>
<body bgcolor="#333333">
    <table align="center">
        <tr>
            <td colspan="4" align="center">
                <font color="#FFFFFF">{{ $item->journey->name }}<br />{{ $item->date }} {{ $no }}/{{ $total }}</font> <b><u>{!! $item->dgrade !!}</u></b>
            </td>
        </tr>
        <tr>
            <td width="2%">
                @if ($prev_item)
                    <a style="color:white" href="{{ url('journey/image/'.$prev_item->journey_id.'/'.$prev_item->id) }}">prev</a>
                @endif
            </td>
            <td align="center" width="48%">
                <img src="{{ $item->dimage }}" width="100%" />
            </td>
            <td align="center" width="48%">
                <img src="{{ $item->dimage2 }}" width="100%" />
            </td>
            <td width="2%">
                @if ($next_item)
                    <a style="color:white" href="{{ url('journey/image/'.$next_item->journey_id.'/'.$next_item->id) }}">next</a>
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" align="center">
                <font color="#FFFFFF">{{ $item->note }}</font>
            </td>
            <td></td>
        </tr>
    </table>
</body>
</html>
