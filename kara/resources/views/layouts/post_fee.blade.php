@if($post->fee_type == 0 || $post->fee == 0)
{{ "توافقی" }}
@elseif($post->fee_type == 1)
    {{  "  روزانه ".  convert(numberFormat(toString($post->fee))).  " تومان  "}}
@else
{{  "  ماهیانه ".  convert(numberFormat(toString($post->fee))).  " تومان  "}}
@endif
