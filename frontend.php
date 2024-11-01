<?php

$dropdown = $instance['dropdown'];
$sort = $instance['sort'];

?>
<div class="bk_WPArchivesTree">
	<div class="loading">
		<img src="https://dev.benyam.in/wp-admin/images/loading.gif" alt="loading.gif"/>
	</div>
	<div class="elements">
		<ul>
			<?php
			$allPosts = get_posts();
			$allDates = array();

			foreach($allPosts as $post_archives) {
				setlocale(LC_ALL, str_replace('-', '_', get_bloginfo("language")) . '.utf8'); 

				$date = strftime("%B %Y",strtotime($post_archives->post_date));
				$dateKey = str_replace(' ', '-', $date);

				if($allDates[$dateKey] == null) {
					$allDates[$dateKey] = array();
				}

				array_push($allDates[$dateKey], $post_archives);
			}

			$count = 1;

			foreach($allDates as $key=>$value) {
				$additionalClass = '';
				if ($count == 1 && $dropdown == 'yes')
					$additionalClass = 'first';

				$outputDates = '<li class="title '.$additionalClass.'" id="'.$count.'">';
				$outputDates .= '<span class="arrowright dashicons dashicons-arrow-right-alt2"></span>';
				$outputDates .= '<span class="arrowdown dashicons dashicons-arrow-down-alt2"></span>';
				$outputDates .= str_replace('-', ' ', $key).' ('.count($value).')</li>';
				$outputDates .= '<li class="subitemlist subitemlist-'.$count.'"><ul>';

				usort($value, array(new Comparaison('post_title', $sort), "compare"));

				foreach($value as $aPost) {
					$outputDates .= '<li class="subitem"><a href="'.get_permalink($aPost).'">'.$aPost->post_title.'</a></li>';
				}

				$outputDates .= '</ul></li>';
				$count++;

				echo $outputDates;
			}
			?>
		</ul>
	</div>
</div>