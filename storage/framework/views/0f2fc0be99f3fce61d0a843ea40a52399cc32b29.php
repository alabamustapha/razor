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
<?php if(sizeof($warnings) == 0): ?>
    <div>
        <u>Tarifs :</u><center><table class="tarificateur">
                <tr><td>Tarif : &nbsp </td><td> <?php echo ' '. round(($result['cotisation']  + $result['juridique']) * $_POST['in_marge'] , 2).' '?> </td><td>&nbsp euros</td></tr>
            </table></center>

        <br><u>Clauses :</u><center><table class="tarificateur">
                <tr><td><?php echo clean_clauses($result['clauses']) ?> </td><td></td></tr>
            </table></center>
    </div>
    <br><div class="form_field"><a href="<?php echo e(url('home')); ?>">Annuler</a> - <a class="btn-orange-a" href="<?php echo e(url('tarificateurgroupama/tarifgroupama_step2')); ?>">Aller &agrave; l'&eacute;tape 2</a></div>
<?php else: ?>
    <?php for($i=0;$i<sizeof($warnings);$i++): ?>
        <?php echo e($warnings[$i]); ?>

    <?php endfor; ?>
<?php endif; ?>