<?php
/**
 * @package Anton
 * @version 1.0
 */
/*
Plugin Name: PLUSO - кнопки социальных сетей
Plugin URI: http://share.pluso.ru/
Description: Кнопки для добавления контента в социальные сети
Armstrong: My Plugin.
Author: Anton
Version: 1.0
Author URI: http://share.pluso.ru/
*/

class PlusoButtons {
	
	function pluso_plugin_blocks() {
		if(isset($_GET['delete'])) { self::pluso_button_delete($_GET['delete']); }
		if(isset($_POST['post_empty'])) { self::pluso_button_insert(); }
		?>

<style type="text/css">
	#status {
		border-collapse:collapse;
		margin-left:20px;
	}
		#status .header td {
			font-size:12px;
			text-align:center;
			background:#EEE;
		}
		#status td {
			padding:5px 10px;
			border:1px solid #DDD;
		}
		#status .submit td {
			padding-top:15px;
			border:none;
		}
			#status td textarea {
				width:280px; height:130px;
			}
			#status td textarea.mess {
				width:230px; height:120px;
			}
			
	.bind-table {width:100%;}
		.bind-table td { padding:0 0 0 25px; vertical-align:top}
			.bind-table td.bind-pic { }
			.bind-table td.bind-pic p { margin-left:25px; }
			.bind-table td.bind-pic select {width:200px; }
			.bind-table .bind-box { float:left; width:50%; }
			.bind-box li { list-style:none; margin:5px 15px;}
			.bind-box div { padding-left:20px; margin-bottom:10px}
			.bind-table h2, .nhvr { background:#EEE; padding:2px 0 2px 15px; margin:0; width:90%; margin-bottom:8px;}
			.nhvr { margin:0 0 15px 20px !important; padding:2px 0 2px 15px !important; width:360px !important }
			.bind-table h3 {
				font-family: "HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",sans-serif; font-size:17px; font-weight:100;
				background:#EEE; padding:5px 0 5px 15px; margin:0; width:90%; margin-bottom:8px;
			}
	
	.p_b_nav { margin:15px 20px}
	.p_b_nav a { display:inline-block; padding:3px 15px; background:#F5F5F5; text-decoration:none; margin-right:10px}
	.p_b_nav a:hover { background:#2993C2; color:#FFF;}
	.p_b_nav a.current-b {background:#237CA4; color:#FFF; }
	#users-status .users-uid {
		padding-right:10px;
	}
	#users-status .submit td {
		padding-top:15px;
	}
	.wait { color:#666;}
	#pic_prev { margin-bottom:10px;}
	.cutpt {
	}
	.shortcode-copy { width:350px; color:#000 !important; background:#EEE !important; color: #00C !important}
	
</style>
<script type="text/javascript">
jQuery(document).ready(function() {
//###########Кнопки
	jQuery("#save_block").click(function() { //Обновить записи кнопок PLUSO
		jQuery.ajax({ 
			url: '<?php bloginfo( 'url' ); ?>/wp-admin/admin-ajax.php?action=upd_pluso_blocks',
			type: 'post',
			data: jQuery('#pluso-form').serialize(),
			beforeSend: function() {
				jQuery("#save_block").attr('disabled', true);
				jQuery("#save_block").before('<span class="wait">Пожалуйста, ждите&nbsp;<img src="<?php echo plugins_url(); ?>/pluso-buttons/tools/loading.gif" alt="" />&nbsp;</span>');
			},
			success: function(html) {
				jQuery(".wait").remove();
				jQuery("#save_block").attr('disabled', false);
			}
		});				
	});
///##########Отображение на страницах
	jQuery("#relationships_save").click(function() { //Обновить взаимосвзять отображение кнопок PLUSO и страниц
		jQuery.ajax({
			url: '<?php bloginfo( 'url' ); ?>/wp-admin/admin-ajax.php?action=add_pluso_relationships',
			type: 'post',
			data: jQuery('#relationships_form').serialize(),
			beforeSend: function() {
				jQuery("#relationships_save").attr('disabled', true);
				jQuery("#relationships_save").after('<span class="wait">&nbsp;<img src="<?php echo plugins_url(); ?>/pluso-buttons/tools/loading.gif" alt="" />&nbsp;Пожалуйста, ждите</span>');
			},
			success: function(html) {
				jQuery(".wait").remove();
				jQuery("#relationships_save").attr('disabled', false);
			}
		});
	});
//###########Вспомогательные
	//confirm delete elem
	jQuery("a.delete-b").live("click", function(){
		if(confirm("Удалить элемент?")) {
			return true;
		} else return false;
	});
	//check all
	jQuery(".check-all").live("click", function() {
		if(jQuery(this).parent().find("input[type=checkbox]").attr('checked') == 'checked') {
			jQuery(this).parent().find("input[type=checkbox]").attr('checked', false);
		} else {
			jQuery(this).parent().find("input[type=checkbox]").attr('checked', true);
		}
		return false;
	});
	//свернуть развернуть
	jQuery(".cutpt").live("click", function() {
		if(jQuery(this).parent().find("li")) {
			if(jQuery(this).parent().find("li:eq(0)").css("display") == 'none') {
				jQuery(this).parent().find("li").slideDown("fast");
				jQuery(this).html("- Свернуть");
			} else {
				jQuery(this).parent().find("li").slideUp("fast");
				jQuery(this).html("+ Развернуть");
			}
		}
		return false;
	});
	
	
	
	jQuery("#data_position_v, #data_position_h").change(function() {
		var h = jQuery("#data_position_h").val(),
			v = jQuery("#data_position_v").val();
		var pic = '<img src="<?php echo plugins_url(); ?>/pluso-buttons/tools/man/' + h + '-' + v + '.gif" />';
		jQuery("#pic_prev").html(pic);
	});
});
</script> 
        
    <div class="wrap">
    	<table width="100%">
        <tr><td>
		<div id="icon-options-general" class="icon32"><br></div>
		<h2>PLUSO - кнопки социальных сетей</h2>
		
		<div class="p_b_nav">
			<a href="<?php bloginfo( 'url' ); ?>/wp-admin/options-general.php?page=pluso_page"<?php if(!isset($_GET['s'])) echo ' class="current-b"'; ?>>Кнопки</a>
			<a href="<?php bloginfo( 'url' ); ?>/wp-admin/options-general.php?page=pluso_page&s=bind"<?php if($_GET['s'] == 'bind') echo ' class="current-b"'; ?>>Отображение</a>
			<a href="<?php bloginfo( 'url' ); ?>/wp-admin/options-general.php?page=pluso_page&s=setting"<?php if($_GET['s'] == 'setting') echo ' class="current-b"'; ?>>Расширенное отображение</a>
		</div>
		</td>
        <td align="left"><div><?php if($_GET['b']) echo '<h2 style="float:left">Предпросмотр</h2>' . self::pluso_button_prew($_GET['b']); ?></div></td>
        </tr>
        </table>
		<?php if($_GET['s'] == 'bind') : ?>
            
		<form id="relationships_form">
			<table class="bind-table">
				<tr>
					<td valign="top" width="400">
						<h2>Кнопки PLUSO</h2>
                        <p style="font-size:11px; color:#444; margin-left:10px">Выберите набор кнопок PLUSO для настройки отображения</p>
						<p><?php self::pluso_select_list(); ?></p>
                        <?php if($_GET['b']) { ?>
                        <br />
                        <p>
                            <h2>Позиция кнопок PLUSO</h2>
                            <table>
                                <tr>
                                    <td>По вертикали:</td>
                                    <td>
                                        <select name="data_position_v" id="data_position_v" style="width:150px">
                                            <option value="m"<?php if(self::handler_position_checked($_GET['b'], 'm')) echo ' selected="selected"'; ?>>Над контентом</option>
                                            <option value="b"<?php if(self::handler_position_checked($_GET['b'], 'b')) echo ' selected="selected"'; ?>>Под контентом</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>По горизонтали:</td>
                                    <td>
                                        <select name="data_position_h" id="data_position_h" style="width:150px">
                                            <option value="l"<?php if(self::handler_position_checked($_GET['b'], 'l')) echo ' selected="selected"'; ?>>Слева</option>
                                            <option value="c"<?php if(self::handler_position_checked($_GET['b'], 'c')) echo ' selected="selected"'; ?>>Посередине</option>
                                            <option value="r"<?php if(self::handler_position_checked($_GET['b'], 'r')) echo ' selected="selected"'; ?>>Справа</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </p>
                        
                        <div id="pic_prev">
						<?php if($nrt = self::pluso_button_prew_pic($_GET['b'])) echo '<img src="'.plugins_url().'/pluso-buttons/tools/man/'.$nrt.'.gif" />';
							else echo '<img src="'.plugins_url().'/pluso-buttons/tools/man/l-t.gif" />'; ?>
                        </div>
                        
						<?php } ?>
                     	<div style="padding-left:5px; padding-top:5px;"><input type="submit" id="relationships_save" value="Сохранить изменения" class="button button-primary" onclick="return false" /></div>
					</td>
					<td>
						<?php if($_GET['b']) : ?>
						<div class="bind-box">
							<h2>Записи</h2>
                            <div style="margin-left:50px; font-size:11px;">
                            	<label style="background:#EDEDED; padding:2px 4px">
                                	<input value="cat" name="in_cats" type="checkbox"<?php if(self::handler_style_checked($_GET['b'], 'cat')) echo ' checked="checked"'; ?> />&nbsp;Отображать в рубриках
                                </label>
                            </div>
                            <input type="hidden" name="b" value="<?php echo $_GET['b']; ?>" />
							<?php $categories=get_categories('orderby=name&order=ASC');
								  foreach($categories as $category) : ?>
							<div>
								<a href="#" class="cutpt"><span>+ Свернуть</span></a>&nbsp;&nbsp;&nbsp;<a href="#" class="check-all"><?php echo $category->cat_name; ?></a>
								<?php $lastposts = get_posts( 'numberposts=-1&category='.$category->term_id.'&orderby=title&order=ASC' );
									  foreach($lastposts as $post) : setup_postdata($post); ?>
										<?php if(self::handler_checked($_GET['b'], $post->ID)) $ckd = ' checked="checked"'; else $ckd = ''; ?>
									<li>
                                    	<label><input <?php echo $ckd; ?> type="checkbox" name="posts_num[]" value="<?php echo $post->ID; ?>" /> <?php echo $post->post_title; ?> (ID: <?php echo $post->ID; ?>)</label>
                                    </li>
									  <?php endforeach; ?>
							</div>
								<?php endforeach; ?>
						</div>
						<div class="bind-box">
							<h2>Страницы</h2>
							<div>
								<a href="#" class="check-all">Все страницы</a>
									<?php $lastposts = get_posts( 'numberposts=-1&post_type=page&exclude=181' );
										  foreach($lastposts as $post) : setup_postdata($post); ?>
									<?php if(self::handler_checked($_GET['b'], $post->ID)) $ckd = ' checked="checked"'; else $ckd = ''; ?>
									<li><label><input <?php echo $ckd; ?> type="checkbox" name="posts_num[]" value="<?php echo $post->ID; ?>" /> <?php echo $post->post_title; ?> (ID: <?php echo $post->ID; ?>)</label></li>
									<?php endforeach; ?>
							</div>
						
							 <!--<h2>Главная страница</h2>
								<div>
									<?php if(self::handler_checked($_GET['b'], 999999)) $ckd = ' checked="checked"'; else $ckd = ''; ?>
									<li><label><input <?php echo $ckd; ?> type="checkbox" name="posts_num[]" value="999999" /> Главная страница</label></li>
								</div>-->
						</div>
						<?php endif; ?>
						</td>
					</tr>
				</table>
						

			</form>
            
		<?php elseif($_GET['s'] == 'setting') : ?>

			<table class="bind-table">
				<tr>
					<td width="100%">
						<div class="bind-box">
							<h2>Виджеты</h2>
							<div>
                            	<p>1. Убедитесь что Ваша тема поддерживает виджеты.</p>
                                <p>2. Вы можете выводить виджет в нужном для Вас месте, для этого просто<br />
                                добавьте этот код в нужном месте шаблона:<br />
                                   &nbsp;&nbsp;<input class="shortcode-copy" type="text" value="if(function_exists('dynamic_sidebar')) dynamic_sidebar('PLUSO-widget-area');" /></p>
                                <p>
                                <p>3. Перейдите <a href="<?php echo get_bloginfo( 'url' ); ?>/wp-admin/widgets.php" target="_blank">на страницу виджетов</a> и внесите код кнопок PLUSO в виджет.</p>
							</div>
						</div>
						<div class="bind-box">
							<h2>Шорт-код</h2>
							<div>
                                Вставьте любой шорт-код из списка
                                    <div style="font-size:14px; padding:4px 0 0 0;">
                                    	<?php self::pluso_shortcode(); ?>
                                    </div>
                                в том месте страницы, где бы Вы хотели видеть кнопки PLUSO
							</div>
						</div>
						</td>
					</tr>
				</table>
			
		<?php else : ?>
        
        	<h2 class="nhvr">Создать набор кнопок PLUSO</h2>
                <table id="status">
                    <form id="pluso-form" method="post">
                    <tr class="header"><td>Действие</td><td>Порядок</td><td>Название</td><td>PLUSO код</td><td>Настройки</td></tr>
                    <?php self::pluso_button_list(); ?>
                    <tr class="submit">
                        <td colspan="6" style="text-align:right">
                            <input type="submit" id="save_block" onclick="return false" name="save_block" class="button button-primary" value="Сохранить изменения" />
                        </td>
                    </tr>
                    </form>
                    <tr class="submit">
                        <td colspan="6">
                            <form action="<?php echo "http://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]"; ?>" method="post">
                                <input type="submit" value="Создать новый набор кнопок" name="post_empty" id="post_empty" />
                            </form>
                        </td>
                    </tr>
                </table>

		<?php endif; ?>
			
		</div>
		<?php
		
	}
	
##########################################
#Кнопки
	//удалить кнопку PLUSO
	function pluso_button_delete($num) {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		$wpdb->query("DELETE FROM $pluso_table WHERE pluso_id = " . (int) $num);
	}
	//Добавляем поле для кнопок
	function pluso_button_insert() {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		$wpdb->insert
		(
			$pluso_table,
			array('pluso_id' => 0, 'sorts' => 0, 'name' => '', 'bcode' => '', 'position' => '', 'style' => ''),
			array('%s', '%s', '%s', '%s', '%s', '%s')
		);
	}
	//Обновить кнопки PLUSO
	function pluso_update() {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		$arr_count = count($_POST['data_pluso_id']);
		for($i = 0; $i < $arr_count; $i++) {
			mysql_query(
				'UPDATE '.$pluso_table.' SET 
				sorts=' .(int) $_POST['data_sorts'][$i].',
				name="'		.$_POST['data_name'][$i].'", 
				bcode="'	.$_POST['data_bcode'][$i].'",
				style="' .$_POST['data_style'].'"
				WHERE pluso_id = '.(int) $_POST['data_pluso_id'][$i]
			) or die(mysql_error());
		}
		die;
	}

	//список существующих наборов кнопок
	function pluso_button_list() {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		if($r = $wpdb->get_results("SELECT * FROM $pluso_table ORDER BY sorts ASC")) {
			$output = '';
			foreach ($r as $item) {
				$output .= '
				<tr>
					<td><input type="hidden" name="data_pluso_id[]" value="'.$item->pluso_id.'" />
					<a href='.get_bloginfo( 'url' ).'/wp-admin/options-general.php?page=pluso_page&delete='.$item->pluso_id.' class="delete-b">Удалить</a></td>
					<td><input type="text" name="data_sorts[]" value="'.$item->sorts.'" size="2" /></td>
					<td><input type="text" name="data_name[]" value="'.$item->name.'" /></td>
					<td><textarea name="data_bcode[]">'.$item->bcode.'</textarea></td>
					<td>
						<p align="center"><a href="'.get_bloginfo( 'url' ).'/wp-admin/options-general.php?page=pluso_page&s=bind&b='.$item->pluso_id.'">Настроить отображение&raquo;</a></p>
					</td>
				</tr>';
			}
			echo $output;
		}
	}
###############################
#Отображение на страницах
	//список кнопок
	function pluso_select_list() {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		$output = '';
		if($r = $wpdb->get_results("SELECT * FROM $pluso_table ORDER BY sorts ASC")) {
			$output .= '<select onchange="location = this.value;"><option value="'.get_bloginfo( "url").'/wp-admin/options-general.php?page=pluso_page&s=bind">Выберите набор кнопок...</option>';
			foreach ($r as $item) {
				if($item->pluso_id == (int) $_GET['b']) $check = ' selected="selected"'; else $check = '';
				$output .= '<option value="'.get_bloginfo( "url").'/wp-admin/options-general.php?page=pluso_page&s=bind&b='.$item->pluso_id.'"'.$check.'>'.$item->name.'</option>';
			}
			$output .= '</select>';
			echo $output;
		}
	}
	//Настройка отображение кнопок на страницах
	function pluso_relationships() {
		global $wpdb;
		$pluso_rel = $wpdb->prefix.plusoblocks_relationships;
		$pluso_table = $wpdb->prefix.plusoblocks;
		if(!empty($_POST['b'])) {
			$wpdb->query("DELETE FROM $pluso_rel WHERE pluso_id = " . (int) $_POST['b']); 
			$arr_count = count($_POST['posts_num']);
			for($i = 0; $i < $arr_count; $i++) {
				//INSERT
				$wpdb->insert
				(
					$pluso_rel,
					array('pluso_id' => (int)$_POST['b'], 'post_id' => (int)$_POST['posts_num'][$i]),
					array('%s', '%s')
				);
			}
			
			mysql_query(
				'UPDATE '.$pluso_table.' SET 
				position="' .$_POST['data_position_h'].'-'.$_POST['data_position_v'].'",
				style="' .$_POST['in_cats']. '"
				WHERE pluso_id = '.(int) $_POST['b']
			) or die(mysql_error());			
			
			echo 'Success';
			die;
		}		
	}
	//Показываем кнопки на страницах
	function pluso_post_blocks($posts) {
		global $wpdb;
		$pluso_blocks = $wpdb->prefix.plusoblocks;
		$pluso_rel = $wpdb->prefix.plusoblocks_relationships;
		$r = $wpdb->get_results("SELECT * FROM $pluso_blocks LEFT JOIN $pluso_rel ON $pluso_blocks.pluso_id = $pluso_rel.pluso_id 
									WHERE $pluso_rel.post_id = ".(int) $posts." ORDER BY sorts ASC");
		if(is_array($r))
			return $r;
		else return false;
	}
	//НЕпосредственно для вставки в хук content
	function pluso_post_insert($content) {
		global $post;
		$dClass = 'wp-pluso-wrapper';
		$cntr 	= '';
		$pS 	= ''; 
		$pE 	= ''; 
		$pered 	= '';
		$posle	= '';
		$attr = ' data-url="'.get_permalink().'" data-title="'.get_the_title().'" data-description="'.self::cut_text(180, get_the_content()).'..."></div>';
		$blocks = self::pluso_post_blocks($post->ID);		
		if($blocks) {
			foreach($blocks as $block) {
				if($block->style == 'cat') { //если в опциях этой записи указан вывод в рубриках, то выводим везде
						$out 	= '';
						$b_bcode = str_replace('></div>', $attr, $block->bcode);
						if($block->position) { $pS = '<div class="pluso-'.$block->position.'">'; $pE = '</div>'; }
						$out .= '<div class="'.$dClass.'">';
						$out .= $pS;
						$out .= $b_bcode;
						$out .= $pE;
						$out .= '</div>';
						
						if($block->position == 'l-m' or $block->position == 'c-m' or $block->position == 'r-m') //только вверху
							$pered .= $out;
						if($block->position == 'l-b' or $block->position == 'c-b' or $block->position == 'r-b')//только низ
							$posle .= $out;
				}
				else { //если в опциях этой записи НЕ указан вывод в рубриках
					if(is_single($post->ID)) { //то выводим только в записи
						$out 	= '';
						$b_bcode = str_replace('></div>', $attr, $block->bcode);
						if($block->position) { $pS = '<div class="pluso-'.$block->position.'">'; $pE = '</div>'; }
						$out .= '<div class="'.$dClass.'">';
						$out .= $pS;
						$out .= $b_bcode;
						$out .= $pE;
						$out .= '</div>';
						
						if($block->position == 'l-m' or $block->position == 'c-m' or $block->position == 'r-m') //только вверху
							$pered .= $out;
						if($block->position == 'l-b' or $block->position == 'c-b' or $block->position == 'r-b')//только низ
							$posle .= $out;
					}
				}
			}
		}
		return $pered . $content . $posle;
	}
	//НЕпосредственно для вставки в хук title
	/*
	function pluso_post_insert_t($title) {
		global $post;
		$dClass = 'wp-pluso-wrapper';
		$pS = ''; $pE = ''; $out = '';
		//$attr = ' data-url="'.get_permalink().'" data-title="'.get_the_title().'" data-description="'.self::cut_text(180, get_the_content()).'..."></div>';
		$blocks = self::pluso_post_blocks($post->ID);		
		if($blocks) {
			foreach($blocks as $block) {
				//$b_bcode = str_replace('></div>', $attr, $block->bcode);
				if($block->position) { $pS = '<div class="pluso-'.$block->position.'">'; $pE = '</div>'; }
				$out .= '<div class="'.$dClass.'">';
				$out .= $pS;
				$out .= $block->bcode;
				$out .= $pE;
				$out .= '</div>';
				
			}
		}
		if($block->position == 'l-t' || $block->position == 'c-t' || $block->position == 'r-t') //если наверху
			return $out.$title;
		else return $title; //значит в content выведем
	}
	*/
	//Подмена шорткода
	function pluso_shortcodes( $atts, $content = null ) {
		return self::pluso_shortcode_to_code($content);
	}
	//сформировать приемер шорт-кода
	function pluso_shortcode() {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		$output = '';
		if($r = $wpdb->get_results("SELECT name FROM $pluso_table ORDER BY pluso_id")) {
			foreach ($r as $item) {
				$output .= '<input class="shortcode-copy" type="text" value="[pluso-buttons]'.$item->name.'[/pluso-buttons]" /><br />';
			}
			echo $output;
		}
	}
	//вытягиваем кнопки по шорткоду шорт-кода
	function pluso_shortcode_to_code($name) {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		$output = '';
		if($r = $wpdb->get_results("SELECT bcode FROM $pluso_table WHERE name='$name'")) {
			foreach ($r as $item) {
				$output = $item->bcode;
			}
			return $output;
		} else return;
	}
	
	
	
	
	
	//Внешний вид кнопок для аддминки
	function pluso_button_prew($num) {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		if($r = $wpdb->get_results("SELECT bcode FROM $pluso_table WHERE pluso_id=$num")) {
			foreach ($r as $item) {
				$output = $item->bcode;
			}
			return $output;
		}
	}
	function pluso_button_prew_pic($num) {
		global $wpdb;
		$pluso_table = $wpdb->prefix.plusoblocks;
		if($r = $wpdb->get_results("SELECT position FROM $pluso_table WHERE pluso_id=$num")) {
			foreach ($r as $item) {
				$output = $item->position;
			}
			return $output;
		}
	}
	function handler_position_checked($button, $select) {
		global $wpdb;
		$table = $wpdb->prefix.plusoblocks;
		if($button) {
			$r = $wpdb->get_results("SELECT position FROM $table WHERE pluso_id = ". (int) $button);
			if($r) {
				$nr = explode('-', $r[0]->position);
				if($nr[0] == $select || $nr[1] == $select) {
					return true;
				}
			} 
			return false;
		}
	}
	function handler_style_checked($button, $select) {
		global $wpdb;
		$table = $wpdb->prefix.plusoblocks;
		if($button) {
			$r = $wpdb->get_results("SELECT style FROM $table WHERE pluso_id = ". (int) $button);
			if($r) {
				if($r[0]->style == $select) {
					return true;
				}
			} 
			return false;
		}
	}
	function handler_checked($bid, $cid) {
		global $wpdb;
		$table = $wpdb->prefix.plusoblocks_relationships;
		if($cid) {
			$r = $wpdb->get_results("SELECT pluso_id FROM $table WHERE post_id = ". (int) $cid . " AND pluso_id = ". (int) $bid);
			if($r) return true;
			else return false;
		}
	}
	function cut_text($len,$str) {
		define ('MAX_WIDTH', $len);
		if (strlen ($str) > MAX_WIDTH)
		$str = substr ($str, 0, MAX_WIDTH-strlen (strrchr (substr ($str, 0, MAX_WIDTH), ' ')));
		//$str = htmlspecialchars($str);
		return strip_tags($str);
	}
	function pluso_widgets() {
		if ( function_exists('register_sidebars') ) {
			register_sidebar(array(
				'name'			=>'PLUSO-widget-area',
				'class'         => '',
				'before_widget' => '',
				'after_widget' 	=> '',
				'before_title' 	=> '',
				'after_title' 	=> ''
			));
		}
	}

	//add link options
	function pluso_menu_link() {
		add_options_page('PLUSO - кнопки социальных сетей', 'PLUSO', 8, 'pluso_page', array('PlusoButtons', 'pluso_plugin_blocks'));
	} 
	function wp_head_pluso_code() {
		echo "<!--PLUSO-->\n<link rel=\"stylesheet\" href=\"".plugins_url()."/pluso-buttons/tools/pluso.css\" media=\"all\" />\n<!--//PLUSO-->";
	}
	function pluso_install() {
		//carousel	table
		global $wpdb;
		$blocks_table = $wpdb->prefix.plusoblocks;	
		$blocks_relationships = $wpdb->prefix.plusoblocks_relationships;	
		$sql1 = 
		"
		CREATE TABLE IF NOT EXISTS `".$blocks_table."` (
		`pluso_id` int(10) NOT NULL AUTO_INCREMENT,
		`sorts` int(3) NOT NULL,
		`name` varchar(20) NOT NULL,
		`bcode` text NOT NULL,
		`position` varchar(9) NOT NULL,
		`style` varchar(200) NOT NULL,
		 PRIMARY KEY (`pluso_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
		";
		$sql2 = 
		"
		CREATE TABLE IF NOT EXISTS `".$blocks_relationships."` (
		`pluso_id` int(10) NOT NULL,
		`post_id` bigint(20) NOT NULL
	   ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	   ";
		$wpdb->query($sql1);
		$wpdb->query($sql2);
	}
	function pluso_uninstall() {
		global $wpdb;
		$blocks_table = $wpdb->prefix.plusoblocks;	
		$blocks_relationships = $wpdb->prefix.plusoblocks_relationships;	
		$sql1 = "DROP TABLE `".$blocks_table."`;";
		$sql2 = "DROP TABLE `".$blocks_relationships."`;";
		$wpdb->query($sql1);
		$wpdb->query($sql2);
	}
}
register_activation_hook( __FILE__, array('PlusoButtons', 'pluso_install'));
register_deactivation_hook( __FILE__, array('PlusoButtons', 'pluso_uninstall'));

add_action('admin_menu', array('PlusoButtons', 'pluso_menu_link'));
##AJAX
//Обновить список кнопок PLUSO
add_action('wp_ajax_upd_pluso_blocks', array('PlusoButtons','pluso_update'));
//Обновить отображение кнопок PLUSO на страницах
add_action('wp_ajax_add_pluso_relationships', array('PlusoButtons','pluso_relationships'));

//Хук для вывода кнопок
add_filter ('the_content', array('PlusoButtons', 'pluso_post_insert'));
add_filter ('the_excerpt', array('PlusoButtons', 'pluso_post_insert'));
//add_filter ('the_title', array('PlusoButtons', 'pluso_post_insert_t'));
//Шорткод
add_shortcode('pluso-buttons', array('PlusoButtons', 'pluso_shortcodes'));
//Виджет
add_action('widgets_init', array('PlusoButtons', 'pluso_widgets'));
 //Скрипты и стили в шапку
add_action('wp_head', array('PlusoButtons', 'wp_head_pluso_code'));