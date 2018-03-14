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
                <tr><td>PNO : &nbsp</td><td> <?php echo ' '. round( (($result['cotisation'] * 0.83 * 1.1 * $_POST['in_marge'])) + $result['juridique'], 2).' '?> </td><td>&nbsp euros</td></tr>
            </table></center>

        <br><u>Clauses :</u><center><table class="tarificateur">
                <tr><td>PNO :<?php echo clean_clauses($result['clauses']) ?> </td><td></td></tr>
            </table></center>
    </div>
    <br><div class="form_field"><a href="{{ url('home') }}">Annuler</a> - <a class="btn-orange-a" href="{{ url('tarificateurbatiment/tarifbat_step2') }}">Aller &agrave; l'&eacute;tape 2</a></div>
@else
    @for($i=0;$i<sizeof($warnings);$i++)
        {{$warnings[$i]}}
    @endfor
@endif

