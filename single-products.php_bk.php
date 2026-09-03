<?php
/**
 * 商品詳細
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$p_name = strip_tags(get_the_title());
$product_colors = $cfs->get('product_colors');
$model_number = $cfs->get('model_number');
$price = $cfs->get('product_price');
$price = str_replace(',','',$price);
$price = intval($price);

$switch_color = '';
if (isset($_GET['color'])) {
	$switch_color = $_GET['color'];
}
// $switch_variation = '';
// if (isset($_GET['variation'])) {
// 	$switch_variation = $_GET['variation'];
// }
?>
	<div class="page pb-5">
		<section class="content_product-slide pb-0">
			<div class="content">
				<div class="product-slide row">
					<div class="product-slide__item col-12 col-lg-6">
						<div class="slick-product_main">
							<?php
								$mines_3d = ['glb', 'gltf'];
								// カラー
								if ($product_colors) :
									foreach ($product_colors as $p_index => $p_colors) :
										$color_name = $p_colors['product_color_name'];
										$color_model_number = $p_colors['color_model_number'];

										$is_display = false;
										if ($switch_color && $switch_color == $color_model_number) {
											$is_display = true;
										} elseif (!$switch_color && $p_index == 1) {
											$is_display = true;
										}

										$key = 'color_file_';
										$movie_key = 'color_3d_movie_';
										$movie_thumbnail_key = 'color_3d_movie_thumbnail_';
										$file_ext = '';

										if ($is_display) :
							?>
										<?php
											// 画像
											for ($i = 0; $i < 7; $i++) :
												$color_file_key = $key.$i+1;
												$color_file = $p_colors[$color_file_key];
												if ($color_file) :
										?>
											<div class="slick-product_main__item">
												<div class="item-img">
													<img src="<?php echo $color_file; ?>" alt="<?php echo $p_name.' '.$color_name; ?>">
												</div>
											</div>
										<?php
												endif;
											endfor;
										?>
										<?php 
											// 動画・3Dモデル
											for ($i = 0; $i < 2; $i++) :
												$movie_file_key = $movie_key.$i+1;
												$movie = $p_colors[$movie_file_key];
												if ($movie) :
												$file_data = pathinfo($movie);
												$file_ext = $file_data['extension'];

												$movie_thumbnail_file_key = $movie_thumbnail_key.$i+1;
												$movie_thumbnail = $p_colors[$movie_thumbnail_file_key];
										?>
											<div class="slick-product_main__item">
												<?php if ($movie && in_array($file_ext, $mines_3d, true) ) : ?>
													<div class="item-3d">
														<model-viewer alt="cat" src="<?php echo $movie; ?>" loading="lazy" camera-controls style="width: 100%; height: 100%;"></model-viewer>
													</div>
												<?php elseif ($movie && $file_ext == 'mp4') : ?>
													<div class="item-movie">
														<video src="<?php echo $movie; ?>" controls loop muted playsinline preload="none" <?php if($movie_thumbnail) echo 'poster="'.$movie_thumbnail.'"'; ?>></video>
													</div>
												<?php endif; ?>
											</div>
										<?php endif; endfor; ?>
										<?php if ($p_colors['color_youtube_movie']) : ?>
											<div class="slick-product_main__item">
												<div class="item-movie youtube">
													<iframe width="100%" height="auto" src="<?php echo $p_colors['color_youtube_movie']; ?>" title="YouTube video player" loading="lazy" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
												</div>
											</div>
										<?php endif; ?>
							<?php
									endif; // if ($is_display) :
								endforeach; endif;
							?>
						</div>
						<div class="slick-product_sub">
							<?php
								// カラー
								if ($product_colors) :

									foreach ($product_colors as $p_index => $p_colors) :
									$color_name = $p_colors['product_color_name'];
									$color_model_number = $p_colors['color_model_number'];

									$is_display = false;
									if ($switch_color && $switch_color == $color_model_number) {
										$is_display = true;
									} elseif (!$switch_color && $p_index == 1) {
										$is_display = true;
									}
									if ($is_display) :

									// 画像
									for ($i = 0; $i < 7; $i++) :
										$color_file_key = $key.$i+1;
										$color_file = $p_colors[$color_file_key];
										if ($color_file) :
								?>
									<div class="slick-product_sub__item">
										<div class="item-th">
											<div class="item_th__img">
												<img src="<?php echo $color_file; ?>" alt="<?php echo $p_name.' '.$color_name; ?>">
											</div>
										</div>
									</div>
								<?php
										endif;
									endfor;
								?>
								<?php 
									// 動画・3Dモデル
									for ($i = 0; $i < 2; $i++) :
										$movie_file_key = $movie_key.$i+1;
										$movie = $p_colors[$movie_file_key];
										$movie_thumbnail_file_key = $movie_thumbnail_key.$i+1;
										$movie_thumbnail = $p_colors[$movie_thumbnail_file_key];

										if ($movie && $movie_thumbnail) :
											$file_data = pathinfo($movie);
											$file_ext = $file_data['extension'];
								?>
									<div class="slick-product_sub__item">
										<div class="item_th item-3d position-relative">
											<div class="item_th__img">
												<img src="<?php echo $movie_thumbnail; ?>" alt="<?php echo $p_name.' '.$color_name; ?>">
											</div>
											<div class="with-icon position-absolute m-auto top-0 bottom-0 start-0 end-0">
												<?php if ($file_ext == 'glb') : ?>
													<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/product/3d-icon.png">
												<?php else : ?>
													<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/product/play-icon.png">
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endif; endfor; ?>
								<?php if ($p_colors['color_youtube_movie']) :?>
									<div class="slick-product_sub__item">
										<div class="item_th item-3d position-relative">
											<div class="item_th__img">
												<img src="<?php echo $p_colors['color_file_1']; ?>" alt="<?php echo $p_name.' '.$color_name; ?>">
											</div>
											<div class="with-icon position-absolute m-auto top-0 bottom-0 start-0 end-0">
												<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/product/play-icon.png">
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endif; endforeach; endif; ?>
						</div>
					</div>
					<div class="product-slide__item product-about d-lg-none">
						<div class="product-about__main">
							<div class="product-about__main__item">
								<h2 class="product-tit"><?php the_title(); ?></h2>
								<?php if ($cfs->get('product_merit')) : ?>
								<div class="product-about__main__item__detail">
									<?php echo $cfs->get('product_merit'); ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="product-slide__item product-about col-12 col-lg-6">
						<div class="product-about__main">
							<div class="product-about__main__item d-none d-lg-block">
								<h2 class="product-tit d-none d-lg-block"><?php the_title(); ?></h2>
								<?php if ($cfs->get('product_merit')) : ?>
								<div class="product-about__main__item__detail">
									<?php echo $cfs->get('product_merit'); ?>
								</div>
								<?php endif; ?>
							</div>
							<?php
								$p_colors = [];
								if ($product_colors) :
									$count_colors = count($product_colors);
									if ($count_colors >= 2) :
							?>
							<div class="product-about__main__item">
								<!-- バリエーションまたはカラーがある場合は「variation」を追加 -->
								<div class="select-img variation">
									<?php if ($product_colors) : ?>
									<div class="select-img__item color">
										<div class="select-img__item__header">
											<h3 class="product-sub-tit">カラー</h3>
											<p class="mb-0">※カラーを選んでいただきますと商品画像が変わります</p>
										</div>
										<div class="select-img__item__body">
											<div class="select-img_list d-flex flex-wrap align-items-center">
												<?php
													foreach ($product_colors as $color_index => $p_colors) :
													$color_name = $p_colors['product_color_name'];
													$color_code = $p_colors['product_color_code'];
													$color_model_number = $p_colors['color_model_number'];

													$is_current = false;
													if ($switch_color && $switch_color == $color_model_number) {
														$is_current = true;
													} elseif (!$switch_color && $color_index == 0) {
														$is_current = true;
													}
												?>
												<div class="select-img_list__item col-6 col-lg-4">
													<button class="select-img_list__item__btn js-switch-btn <?php if ($is_current) echo ' is-current';?>" data-color="<?php echo $color_model_number; ?>">
														<p class="mb-0">
															<?php
																$color_code_name = str_replace('#', '', $color_code);
																$color_code_name = strtolower($color_code_name);
																$color_code_image_url = get_stylesheet_directory_uri()."/assets/img/product/colors/".$color_code_name.".jpg";
																if (file_exists(get_template_directory()."/assets/img/product/colors/".$color_code_name.".jpg")) {
																	$color_code_file = true;
																} else {
																	$color_code_file = false;
																}
															?>
															<span class="color-icon rounded-circle" style="background: <?php if($color_code_file) { echo 'url('.$color_code_image_url.') no-repeat center'; } else { echo $color_code; } ?>;"></span>
															<span class="color-name d-inline-block"><?php echo $color_name; ?></span>
														</p>
													</button>
												</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
									<?php endif; // if ($product_colors)?>
								</div>
							</div>
							<?php endif; endif; ?>
						</div>
						<div class="product-about__sub mt-3">
							<?php 
								$product_merit = CFS()->get('product_merit');
								if ($product_merit) :
							?>
							<div class="product-about__sub__item">
								<h3 class="product-item_tit">特長</h3>
								<div class="product-item_detail">
									<?php echo $product_merit; ?>
								</div>
							</div>
							<?php endif; ?>
							<div class="product-about__sub__item">
								<h3 class="product-item_tit">仕様</h3>
								<div class="product-item_detail">
									<div class="specification_list">
										<div class="specification_list__item d-flex">
											<div class="specification_list__item__tit col-4">
												<p class="mb-0">品番</p>
											</div>
											<div class="specification_list__item__about col-8">
												<p class="mb-0">
													<?php
														echo $model_number; // 共通品番
														if ($switch_color) { // カラー別品番
															echo '-'.$switch_color;
														} else {
															foreach ($product_colors as $index => $product_color) {
																if ($index == 0) {
																	echo '-'.$product_color['color_model_number'];
																} else {
																	break;
																}
															}
														}
													?>
												</p>
											</div>
										</div>

										<div class="specification_list__item d-flex">
											<div class="specification_list__item__tit col-4">
												<p class="mb-0">希望小売価格</p>
											</div>
											<div class="specification_list__item__about col-8">
												<p class="mb-0">
													<?php
														//共通価格（バリエーション・カラーがない場合）
														if ($price) {
															echo '¥'.number_format($price*1.1).'（¥'.number_format($price).' 税抜）<br>';
														} else {
															// カラー別価格
															if ($product_colors) {
																foreach ($product_colors as $p_colors) {
																	$color_model_number = $p_colors['color_model_number'];
																	if ($switch_color && $switch_color == $color_model_number) {
																		if ($p_colors['price_color_non_taxed']) {
																			$price_color_non_taxed = str_replace(',','',$p_colors['price_color_non_taxed']);
																			$price_color_non_taxed = intval($price_color_non_taxed);
																			echo ' ¥'.number_format($price_color_non_taxed*1.1).'（¥'.number_format($price_color_non_taxed).' 税抜）';
																		}
																		break 1;
																	} elseif (!$switch_color && $color_model_number) {
																		if ($p_colors['price_color_non_taxed']) {
																			$price_color_non_taxed = str_replace(',','',$p_colors['price_color_non_taxed']);
																			$price_color_non_taxed = intval($price_color_non_taxed);
																			echo ' ¥'.number_format($price_color_non_taxed*1.1).'（¥'.number_format($price_color_non_taxed).' 税抜）';
																		}
																		break 1;
																	}
																}
															}
														}
													?>
												</p>
											</div>
										</div>

										<?php
											// 仕様
											$item_key = 'item_';
											$item_name = array('スパウト', '対応穴径', '吐水', '回転範囲', '節湯', 'JWWA', 'サイズ', '材質', '設置タイプ', '排水口径', 'オーバーフロー', '付属品', '引き棒', 'ボウル深さ', '水栓取付穴径', '容量', '重量', '備考1', '備考2');
											for ($i = 0; $i < 19; $i++) :
												$item_index_key = $item_key.$i+1;
												$item = $cfs->get($item_index_key);
												if ($item):
										?>
											<div class="specification_list__item d-flex">
												<div class="specification_list__item__tit col-4">
													<p class="mb-0"><?php echo $item_name[$i]; ?></p>
												</div>
												<div class="specification_list__item__about col-8">
													<p class="mb-0"><?php echo $item; ?></p>
												</div>
											</div>
										<?php endif; endfor; ?>
										<?php
											// 仕様
											$item_name_key = 'item_name_';
											$item_about_key = 'item_about_';
											for ($i = 0; $i < 5; $i++) :
												$item_name_index_key = $item_key.$i+1;
												$item_name = $cfs->get($item_name_index_key);
												$item_about_index_key = $item_about_key.$i+1;
												$item_about = $cfs->get($item_about_index_key);
												if ($item_name && $item_about):
										?>
										<div class="specification_list__item d-flex">
											<div class="specification_list__item__tit col-4">
												<p class="mb-0"><?php echo $item_name; ?></p>
											</div>
											<div class="specification_list__item__about col-8">
												<p class="mb-0"><?php echo $item_about; ?></p>
											</div>
										</div>
										<?php endif; endfor; ?>
									</div>
								</div>
							</div>
							<?php
								$document_list = $cfs->get('document_list');
								if ($document_list[0]['document_url']) :
							?>
								<div class="product-about__sub__item">
									<h3 class="product-item_tit">関連資料</h3>
									<div class="product-item_detail document_list">
										<?php 
											foreach ($document_list as $document_lists) :
												$document_name = $document_lists['document_name'];
												$document_url = $document_lists['document_url'];
												$document_link_blank = $document_lists['document_link_blank'];
										?>
										<div class="document_list__item">
											<a href="<?php echo $document_url; ?>" <?php if ($document_link_blank === 1) echo 'target="_blank"'; ?>>
												<p class="mb-0"><span><?php echo $document_name; ?></span><i class="fa-solid fa-arrow-up-right-from-square ps-1"></i></p>
											</a>
										</div>
										<?php
											endforeach;
										?>	
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- <section class="content_construction pb-0">
			<div class="content">
				<div class="content_construction__item">
					<h3 class="product-item_tit">施工事例</h3>
					<div class="construction-list row">
						<div class="construction-list__item mb-4 col-12 col-lg-4">
							<div class="construction-list__item__img mb-2">
								<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/portfolio-sample2.jpg" alt="">
							</div>
							<div class="construction-list__item__about">
								<h4 class="construction-tit">タイトルタイトル</h4>
								<p class="mb-0">説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明</p>
							</div>
						</div>
						<div class="construction-list__item mb-4 col-12 col-lg-4">
							<div class="construction-list__item__img mb-2">
								<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/portfolio-sample2.jpg" alt="">
							</div>
							<div class="construction-list__item__about">
								<h4 class="construction-tit">タイトルタイトル</h4>
								<p class="mb-0">説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明</p>
							</div>
						</div>
						<div class="construction-list__item mb-4 col-12 col-lg-4">
							<div class="construction-list__item__img mb-2">
								<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/portfolio-sample2.jpg" alt="">
							</div>
							<div class="construction-list__item__about">
								<h4 class="construction-tit">タイトルタイトル</h4>
								<p class="mb-0">説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明説明</p>
							</div>
						</div>
					</div>
					<div class="link-btn black-btn text-center">
						<a href="<?php echo home_url(); ?>/construction/domestic/">
							<button>
								<p class="mb-0">全ての事例を見る<i class="fa-solid fa-chevron-right"></i></p>
							</button>
						</a>
					</div>
				</div>
			</div>
		</section> -->
	</div>
<?php
get_footer();
?>