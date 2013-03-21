<?php 
	ob_start(); 
	include_once 'class.search_rss.php';
	$rss = new SearchRss();
	
?>

<?php include_once 'header.php'; ?>

<table>
	<tr>
		<td><?=LANG_INSERT_SEAR_RSS_KEY?></td>
		<td>
			<form method="GET" action="./search.php">
				<input type="hidden" name="action" value="search_rss"/>
				<input type="text" name="word" size="45" maxlength="20" />
				<button type="submit"><?=LANG_SEARCH?></button>
			</form>
		</td>
	</tr>
</table>
		
<?php include_once 'footer.php'; ?>
<?php ob_end_flush(); ?>