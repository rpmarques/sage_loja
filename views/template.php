
<?php 
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>SAGE Loja 2.0</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.structure.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.theme.min.css" type="text/css" />
		<!-- COLOCO AQUI POR CAUSA DO PAGSEGURO -->
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
	</head>
	<body>
		<nav class="navbar topnav">
			<div class="container">
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?php echo BASE_URL; ?>"><?php $this->lang->get('HOME'); ?></a></li>
					<li><a href="<?php echo BASE_URL; ?>contact"><?php $this->lang->get('CONTACT'); ?></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('LANGUAGE'); ?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo BASE_URL; ?>lang/set/en">English</a></li>
							<li><a href="<?php echo BASE_URL; ?>lang/set/pt-br">Português</a></li>
						</ul>
					</li>
					<li><a href="<?php echo BASE_URL; ?>login"><?php $this->lang->get('LOGIN'); ?></a></li>
				</ul>
			</div>
		</nav>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-sm-2 logo">
						<a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/images/logo.png" /></a>
					</div>
					<div class="col-sm-7">
						<div class="head_help">(11) 9999-9999</div>
						<div class="head_email">contato@<span>loja2.com.br</span></div>
						
						<!-- BUSCA -->
						<div class="search_area">
							<form method="GET" action="<?= BASE_URL;?>busca">
								<input type="text" name="s" value="<?=(!empty($viewData['textoBusca']))?$viewData['textoBusca']:'';?>" required placeholder="<?php $this->lang->get('SEARCHFORANITEM'); ?>" />
								<select name="category">
									<option value=""><?php $this->lang->get('ALLCATEGORIES'); ?></option>
								<?php 
								 foreach($viewData['categories'] as $categorias): ?>									
									<option <?= (isset($viewData['category']) && $viewData['category']==$categorias['id'])?'selected="selected"':'';?> value="<?= $categorias['id']; ?>"> <?=$categorias['name']; ?></option>								
									<?php 
									// echo '<pre>';
									// var_dump($categorias);
										if (count($categorias['subs']) > 0 ){
											$this->loadView('search_subcategory',array(
												'subs' => $categorias['subs'],
												'nivel' => 1,
												'category' => (isset($viewData['category']))?$viewData['category']:'' // FAÇO ISSO PRA PASSAR PRA DENTRO DO VIEW search_subcategory EU POSSA ACESSAR ELE...
											));
										}
									?>
							  <?php  endforeach ; ?>									
								</select>
								<input type="submit" value="" />
						    </form>
						</div>
						<!-- FIM BUSCA -->
					</div>
					<div class="col-sm-3">
						<a href="<?php echo BASE_URL; ?>cart">
							<div class="cartarea">
								<div class="carticon">
									<div class="cartqt"><?= $viewData['carrinho_qt'];?></div>
								</div>
								<div class="carttotal">
									<?php $this->lang->get('CART'); ?>:<br/>
									<span>R$ <?= number_format($viewData['carrinho_subtotal'],2,',','.');?></span>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</header>
		<div class="categoryarea">
			<nav class="navbar">
				<div class="container">
					<ul class="nav navbar-nav">
						<li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('SELECTCATEGORY'); ?>
					        <span class="caret"></span></a>
					        <ul class="dropdown-menu">
					          <?php  foreach($viewData['categories'] as $categorias): ?>
								<li>
									<a href="<?= BASE_URL.'categories/enter/'.$categorias['id']?>"> <?= $categorias['name'];?></a>
								</li>
								<?php 
									if (count($categorias['subs']) > 0 ){
										$this->loadView('menu_subcategory',array(
											'subs' => $categorias['subs'],
											'nivel' => 1
										));
									}
								?>
							  <?php  endforeach ; ?>
					        </ul>
					      </li>
						  <!-- AQUI É A TRILHA DE MIGALHA -->
						<?php if (isset($viewData['category_filter'])):?>
							<?php foreach($viewData['category_filter'] as $cf):?>
								<li>
									<a href="<?= BASE_URL;?>categories/enter/<?= $cf['id']?>"><?= $cf['name'];?></a>
								</li>
							<?php endforeach;?>							
						<?php endif;?>						
					</ul>
				</div>
			</nav>
		</div>
		<section>
			<div class="container">
				<div class="row">
				<?php if(isset($viewData['sidebar'])) :?>
					<div class="col-sm-3">
						<?php $this->loadView('sidebar',array('viewData'=>$viewData)) ?>
					</div>
					<!-- AQUI LISTA OS PRODUTOS -->
					<div class="col-sm-9">
						<?php $this->loadView($viewName, $viewData); ?>
					</div>
				<?php else:?>
				
					<div class="col-sm-12">
						<?php $this->loadView($viewName, $viewData); ?>
					</div>
				
				<?php endif;?>
					
				</div>
	    	</div>
	    </section>
	    <footer>
	    	<div class="container">
	    		<div class="row">
				  <div class="col-sm-4">
				  	<div class="widget">
			  			<h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
			  			<div class="widget_body">
						  <?php $this->loadView('widget_item',array('list' => $viewData['widget_destaque2'])) ?>
			  			</div>
			  		</div>
				  </div>
				  <div class="col-sm-4">
				  	<div class="widget">
			  			<h1><?php $this->lang->get('ONSALEPRODUCTS'); ?></h1>
			  			<div class="widget_body">
			  				<?php $this->loadView('widget_item',array('list' => $viewData['widget_promocao'])) ?>
			  			</div>
			  		</div>
				  </div>
				  <div class="col-sm-4">
				  	<div class="widget">
			  			<h1><?php $this->lang->get('TOPRATEDPRODUCTS'); ?></h1>
			  			<div class="widget_body">
						  <?php $this->loadView('widget_item',array('list' => $viewData['widget_melhores'])) ?>
			  			</div>
			  		</div>
				  </div>
				</div>
	    	</div>
	    	<div class="subarea">
	    		<div class="container">
	    			<div class="row">
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
							<!-- Begin Mailchimp Signup Form -->
							<form action="https://gmail.us1.list-manage.com/subscribe/post?u=8eed36d080430326be5c54f1f&amp;id=01965a42ae" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<input type="email" value="" name="EMAIL" class=" subemail required email" id="mce-EMAIL" placeholder="<?php $this->lang->get('SUBSCRIBETEXT'); ?>">
								<input type="hidden" name="b_8eed36d080430326be5c54f1f_01965a42ae" tabindex="-1" value="">
								<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button" value="<?php $this->lang->get('SUBSCRIBEBUTTON'); ?>">
							</form>
						</div>
					</div>
	    		</div>
	    	</div>
	    	<div class="links">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-4">
							<a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/logo.png" /></a><br/><br/>
							<strong>Slogan da Loja Virtual</strong><br/><br/>
							Endereço da Loja Virtual
						</div>
						<div class="col-sm-8 linkgroups">
							<div class="row">
								<div class="col-sm-4">
									<h3><?php $this->lang->get('CATEGORIES'); ?></h3>
									<ul>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
										<li><a href="#">Categoria X</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h3><?php $this->lang->get('INFORMATION'); ?></h3>
									<ul>
										<li><a href="#">Menu 1</a></li>
										<li><a href="#">Menu 2</a></li>
										<li><a href="#">Menu 3</a></li>
										<li><a href="#">Menu 4</a></li>
										<li><a href="#">Menu 5</a></li>
										<li><a href="#">Menu 6</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h3><?php $this->lang->get('INFORMATION'); ?></h3>
									<ul>
										<li><a href="#">Menu 1</a></li>
										<li><a href="#">Menu 2</a></li>
										<li><a href="#">Menu 3</a></li>
										<li><a href="#">Menu 4</a></li>
										<li><a href="#">Menu 5</a></li>
										<li><a href="#">Menu 6</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
	    		</div>
	    	</div>
	    	<div class="copyright">
	    		<div class="container">
	    			<div class="row">
						<div class="col-sm-6">© <span>Loja 2.0</span> - <?php $this->lang->get('ALLRIGHTRESERVED'); ?>.</div>
						<div class="col-sm-6">
							<div class="payments">
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
								<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
							</div>
						</div>
					</div>
	    		</div>
	    	</div>
	    </footer>
		<script type="text/javascript">
			var BASE_URL = '<?php echo BASE_URL; ?>';			
			var maxslider = <?= $viewData['filters']['slidermax']; ?>;
		</script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
	</body>
</html>