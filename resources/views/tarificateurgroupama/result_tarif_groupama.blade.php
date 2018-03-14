@if(sizeof($warnings) == 0)
    <div>
        <u>Tarifs :</u><center><table class="tarificateur">
                <tr><td>Resultat</td><td> <?php echo ' '. round($result * 1.17).' '?> </td><td>&nbsp euros</td></tr>
            </table></center>
    </div>
    {{--<br><div class="form_field"><a href="{{ url('home') }}">Annuler</a> - <a class="btn-orange-a" href="{{ url('tarificateurgroupama/tarifgroupama_step2') }}">Aller &agrave; l'&eacute;tape 2</a></div>--}}
@else
    @for($i=0;$i<sizeof($warnings);$i++)
        {{$warnings[$i]}}
    @endfor
@endif