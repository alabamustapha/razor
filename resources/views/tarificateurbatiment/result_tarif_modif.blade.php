<?php
function clean_clauses($clauses)
{
    $max = strlen($clauses);
    for($i = 0;$i < $max;$i++)
        $clauses = str_replace(",,", ",", $clauses);
    if (strlen($clauses) > 0 && $clauses[0] == ',')
        $clauses[0] = " ";
    if (strlen($clauses) > 0 && $clauses[strlen($clauses)-1] == ',')
        $clauses[strlen($clauses)-1] = " ";
    return trim(rtrim($clauses));
}
?>

@if(sizeof($warnings) == 0)
    <div>
        <u>Tarifs :</u><center><table class="tarificateur">
                <tr><td>PNO : </td><td><?php echo round( (($result['cotisation'] * 0.83 * 1.1 * $_POST['in_marge'])) + $result['juridique'], 2)?></td><td> euros</td></tr>
            </table></center>

        <br><u>Clauses :</u><center><table class="tarificateur">
                <tr><td>PNO :<?php echo clean_clauses($result['clauses']) ?> </td><td></td></tr>
            </table></center>
    </div>
    <br><center><div class="form_field"><a href="{{ url('home') }}">Annuler</a> - <button class="btn-orange-a" style="border: none!important; background-color: transparent" type="submit">Modifier</button></div></center>
@else
    @for($i=0;$i<sizeof($warnings);$i++)
        {{$warnings[$i]}}
    @endfor
@endif
