<?php
defined('_JEXEC') or die;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$menu = $app->getMenu();
$lang = JFactory::getLanguage();

$template_url = $this->baseurl . '/templates/' . $this->template;



$is_home_page = $menu->getActive() == $menu->getDefault($lang->getTag());
$bootstrap_path = $this->baseurl . '/media/vendor/bootstrap/css';
$logo		= $this->params->get('logo');
$color      = $this->params->get('templatecolor');
$this->setHtml5(true);
$template_path = $this->baseurl . '/templates/' . $this->template;
?>

<!doctype html>
<html>
<head>
    <jdoc:include type="head"/>
    <meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="viewport"
content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet"
href="<?php echo $bootstrap_path; ?>/bootstrap.css"
type="text/css" />
<link rel="stylesheet"
href="<?php echo $bootstrap_path; ?>/bootstrap-grid.css"
type="text/css" />
<link rel="stylesheet"
href="<?php echo $bootstrap_path; ?>/bootstrap-reboot.css"
type="text/css" />

	  <link rel="stylesheet" href="<?php echo $template_path; ?>/css/<?php echo htmlspecialchars($color, ENT_COMPAT, 'UTF-8')?>.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php ?>
</head>
<body>

<div class="wrapper">
    
    <header>
        <div class="row">
            <div class="col-6"><a href="/"><img src="<?php echo $logo?>" alt="<?php echo JText::_('TPL_WHITESQUARE_LOGO');?>"></a>
            </div>  
           <div class="col-6"> <jdoc:include type="modules" name="search"/></div>
        </div>
        
    </header>
    <nav class="main-navigation container navbar navbar-dark bg-dark">
        <div class="row">
            <div class="col-12">
            <jdoc:include type="modules" name="menu"/>
            </div>
        </div>
        
        
    </nav>
    
        <main>
        
        <div class="contaniner">
            <div class="row">
                <div class="col-3"><jdoc:include type="modules" name="left"/></div>
                <div class="col-6"><jdoc:include type="modules" name="main"/><jdoc:include type="component"/></div>
                <div class="col-3"><jdoc:include type="modules" name="right"/></div>
            </div>
        </div>
    </main>
    
    
    <jdoc:include type="message"/>
    
    

<footer>
    
</footer>
</body>
</html>