<html>
<head>
    <style>
        img {
            width: 70vw;
            height: auto;
        }
    </style>
</head>
<body bgcolor="#333333">
    <table align="center">
        <tr>
            <td colspan="4" align="center">
                <font color="#FFFFFF">{{ $item->journey->name }}<br />{{ $item->date }} {{ $no }}/{{ $total }}</font> <b><u>{!! $item->dgrade !!}</u></b>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" align="center">
                <font color="#FFFFFF">{{ $item->note }}</font>
            </td>
            <td></td>
        </tr>
        <tr>
            <td width="2%">
                @if ($prev_item)
                    <a style="color:white" href="{{ url('journey/image/'.$prev_item->journey_id.'/'.$prev_item->id) }}">prev</a>
                @endif
            </td>
            @if ($item->image && $item->image2)
                <td align="center" width="25%">
                    <img src="{{ $item->dimage }}" />
                </td>
                <td align="center" width="25%">
                    <img src="{{ $item->dimage2 }}" />
                </td>
            @else
                <td align="center" width="25%">
                    <img src="{{ $item->dimage }}" />
                </td>
            @endif
            <td width="2%">
                @if ($next_item)
                    <a style="color:white" href="{{ url('journey/image/'.$next_item->journey_id.'/'.$next_item->id) }}">next</a>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
