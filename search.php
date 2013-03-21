<?php
	include_once 'class.search_rss.php';
	$rss = new SearchRss();
	$rss->get = $_GET;
	$rss->action();
?>

<?php include_once 'header.php'; ?>

<table>
	<tr>
		<td><?=$rss->result?></td>
	</tr>
	<?php 
	$i=1;
	if($rss->found==true){
		
		foreach($rss->rss_arr as $rss_val){
		?>
		<tr>
			<td><?=$i++?></td>
			<td><a href="<?=$rss_val[link]?>" title="<?=$rss_val[title]?>"><?=$rss_val[title]?></a></td>
			<td><?=LANG_POSTED_ON?>: <?=$rss_val[pubDate]?></td>
		</tr>
		<?php 
		} 
		?>
	<?php 
	} 
	?>
	<tr>
		<td colspan="3">
			<form method="GET" action="./search.php">
				<input type="hidden" name="action" value="clear_rss"/>
				<button type="submit"><?=LANG_BACK?></button>
			</form>
		</td>
	</tr>
</table>

<?php include_once 'footer.php'; ?>
