<?php
/**
 * innovativePotential functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package innovativePotential
 */

if ( ! function_exists( 'innovativepotential_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function innovativepotential_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on innovativePotential, use a find and replace
		 * to change 'innovativepotential' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'innovativepotential', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'innovativepotential' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'innovativepotential_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'innovativepotential_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function innovativepotential_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'innovativepotential_content_width', 640 );
}
add_action( 'after_setup_theme', 'innovativepotential_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function innovativepotential_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'innovativepotential' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'innovativepotential' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'innovativepotential_widgets_init' );


//add url for ajax
function my_enqueue() {

	wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/ajax-req.js', array('jquery') );

    wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );

/**
 * Enqueue scripts and styles.
 */
function innovativepotential_scripts() {
	//scripts
	wp_enqueue_style( 'innovativepotential-style', get_stylesheet_uri() );

	wp_enqueue_script( 'innovativepotential-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery-script', get_template_directory_uri() .'/js/jquery-3.4.1.min.js' , array(), null, false );

	wp_enqueue_script( 'innovativepotential-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'general-script', get_template_directory_uri() .'/js/general.js' , array(), null, false );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() .'/js/bootstrap.min.js' , array(), null, false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	//styles
	wp_enqueue_style('bootstrap-style', get_theme_file_uri('/css/bootstrap.min.css'), array(), null);
}
add_action( 'wp_enqueue_scripts', 'innovativepotential_scripts' );


function importExcelDA($inputFileName1)
{
	// library
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel5.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel2007.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/IOFactory.php');


	// $inputFileName = get_template_directory().'/BD.xlsx';
	$inputFileName = $inputFileName1;
	

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}
	$objPHPExcel->setActiveSheetIndex(0);
	$sheet = $objPHPExcel ->getActiveSheet();
	$array_data = array();
	$array_dataRate = array();
	$array_answerWeight = array(1,1,1,0.05,0.03,0.05,0.03,0.05,0.05,0.03,0.05,0.03,0.03,0.03,0.05,0.03,0.03,0.05,0.03,0.03,0.03,1,
								0.05,0.05,0.03,0.03,0.03,0.05,0.03,0.05,0.05,0.05,0.03,0.03,0.03,0.05,0.03,0.05);
	foreach($sheet->getRowIterator() as $row){

		$rowIndex = $row->getRowIndex ();
		if ($rowIndex == 1) {
			$rowIndex = $row->getRowIndex() + 1;
		}
		$array_data[$rowIndex] = array(
			'A'=>'', 'B'=>'', 'C'=>'',
			'E'=>'','F'=>'','G'=>'','H'=>'','I'=>'','J'=>'','K'=>'','L'=>'','M'=>'','N'=>'','O'=>'',
			'P'=>'','Q'=>'','R'=>'','S'=>'','T'=>'','U'=>'','V'=>'','W'=>'','X'=>'','Y'=>'','Z'=>'',
			'AA'=>'','AB'=>'','AC'=>'','AD'=>'','AE'=>'','AF'=>'','AG'=>'','AH'=>'','AI'=>'','AJ'=>'','AK'=>'',
			'AL'=>'','AM'=>'',
		);
		
		$cell = $sheet->getCell('A' . $rowIndex);
		$array_data[$rowIndex]['A'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('B' . $rowIndex);
		$array_data[$rowIndex]['B'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('C' . $rowIndex);
		$array_data[$rowIndex]['C'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('E' . $rowIndex);
		$array_data[$rowIndex]['E'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('F' . $rowIndex);
		$array_data[$rowIndex]['F'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('G' . $rowIndex);
		$array_data[$rowIndex]['G'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('H' . $rowIndex);
		$array_data[$rowIndex]['H'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('I' . $rowIndex);
		$array_data[$rowIndex]['I'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('J' . $rowIndex);
		$array_data[$rowIndex]['J'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('K' . $rowIndex);
		$array_data[$rowIndex]['K'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('L' . $rowIndex);
		$array_data[$rowIndex]['L'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('M' . $rowIndex);
		$array_data[$rowIndex]['M'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('N' . $rowIndex);
		$array_data[$rowIndex]['N'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('O' . $rowIndex);
		$array_data[$rowIndex]['O'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('P' . $rowIndex);
		$array_data[$rowIndex]['P'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('Q' . $rowIndex);
		$array_data[$rowIndex]['Q'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('R' . $rowIndex);
		$array_data[$rowIndex]['R'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('S' . $rowIndex);
		$array_data[$rowIndex]['S'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('T' . $rowIndex);
		$array_data[$rowIndex]['T'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('U' . $rowIndex);
		$array_data[$rowIndex]['U'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('V' . $rowIndex);
		$array_data[$rowIndex]['V'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('W' . $rowIndex);
		$array_data[$rowIndex]['W'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('X' . $rowIndex);
		$array_data[$rowIndex]['X'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('Y' . $rowIndex);
		$array_data[$rowIndex]['Y'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('Z' . $rowIndex);
		$array_data[$rowIndex]['Z'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AA' . $rowIndex);
		$array_data[$rowIndex]['AA'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AB' . $rowIndex);
		$array_data[$rowIndex]['AB'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AC' . $rowIndex);
		$array_data[$rowIndex]['AC'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AD' . $rowIndex);
		$array_data[$rowIndex]['AD'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AE' . $rowIndex);
		$array_data[$rowIndex]['AE'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AF' . $rowIndex);
		$array_data[$rowIndex]['AF'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AG' . $rowIndex);
		$array_data[$rowIndex]['AG'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AH' . $rowIndex);
		$array_data[$rowIndex]['AH'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AI' . $rowIndex);
		$array_data[$rowIndex]['AI'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AJ' . $rowIndex);
		$array_data[$rowIndex]['AJ'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AK' . $rowIndex);
		$array_data[$rowIndex]['AK'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AL' . $rowIndex);
		$array_data[$rowIndex]['AL'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('AM' . $rowIndex);
		$array_data[$rowIndex]['AM'] = $cell->getCalculatedValue();
		if ($array_data[$rowIndex]['AM'] == '') {
			unset($array_data[$rowIndex]);
			
			break;
		}
	}
	$array_dataSize = count($array_data);
	$countData = 0;
	$array_col = array('A','B','C','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
						'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM');
	$array_colSize = count($array_col);
	$array_x = array();
	for($count = 0; $count < $array_dataSize; $count++){
		if ($count == 0) {
			$countData = $count + 2;
		}
		$array_dataRate[$count] = array(
			'A'=>'', 'B'=>'', 'C'=>'',
			'E'=>'','F'=>'','G'=>'','H'=>'','I'=>'','J'=>'','K'=>'','L'=>'','M'=>'','N'=>'','O'=>'',
			'P'=>'','Q'=>'','R'=>'','S'=>'','T'=>'','U'=>'','V'=>'','W'=>'','X'=>'','Y'=>'','Z'=>'',
			'AA'=>'','AB'=>'','AC'=>'','AD'=>'','AE'=>'','AF'=>'','AG'=>'','AH'=>'','AI'=>'','AJ'=>'','AK'=>'',
			'AL'=>'','AM'=>'', 'AN'=>''
		);
		for ($i=0; $i < $array_colSize; $i++) { 
			$col = $array_col[$i];
			if ($col == 'A' || $col == 'B' || $col == 'C') {
				$array_dataRate[$count][$col] = $array_data[$countData][$col];
			} else {
				$array_dataRate[$count][$col] = $array_data[$countData][$col] * $array_answerWeight[$i];
			}
			
			
		}
		
		
		$countData = $countData + 1;
	}
	$array_dataRateSize = count($array_dataRate);
	for ($i=0; $i < $array_dataRateSize; $i++) { 
		for ($j=0; $j < $array_colSize; $j++) { 
			$col = $array_col[$j];
			if ($col == 'A' || $col == 'B' || $col == 'C') {
				$array_x[$i] = $array_dataRate[$i][$col];
			} else {
				$array_x[$i] = array_sum($array_dataRate[$i]);
			}
		}
		$array_dataRate[$i]['AN'] = $array_x[$i];
		
	}
	$countString = $rowIndex - 2;

	
	return $array_dataRate;
}
add_action('wp_ajax_importExcelDA', 'importExcelDA');
add_action('wp_ajax_nopriv_importExcelDA', 'importExcelDA');

function importExcelTC($inputFileName2){
	// library
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel5.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel2007.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/IOFactory.php');

	// $inputFileName = get_template_directory().'/TB.xlsx';
	$inputFileName = $inputFileName2;
	

	//  Read your Excel workbook
	try {
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
	} catch(Exception $e) {
		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	$objPHPExcel->setActiveSheetIndex(0);
	$sheet = $objPHPExcel ->getActiveSheet();
	$array_data = array();
	foreach($sheet->getRowIterator() as $row){
		$rowIndex = $row->getRowIndex ();
		if ($rowIndex == 1) {
			$rowIndex = $row->getRowIndex() + 1;
		}
		$array_data[$rowIndex] = array(
			'A'=>'', '2010'=>'', '2011'=>'', '2012'=>'',
			'2013'=>'','2014'=>'','2015'=>'','2016'=>'','2017'=>'','2018'=>'',
		);
		
		$cell = $sheet->getCell('A' . $rowIndex);
		$array_data[$rowIndex]['A'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('B' . $rowIndex);
		$array_data[$rowIndex]['2010'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('C' . $rowIndex);
		$array_data[$rowIndex]['2011'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('D' . $rowIndex);
		$array_data[$rowIndex]['2012'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('E' . $rowIndex);
		$array_data[$rowIndex]['2013'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('F' . $rowIndex);
		$array_data[$rowIndex]['2014'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('G' . $rowIndex);
		$array_data[$rowIndex]['2015'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('H' . $rowIndex);
		$array_data[$rowIndex]['2016'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('I' . $rowIndex);
		$array_data[$rowIndex]['2017'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('J' . $rowIndex);
		$array_data[$rowIndex]['2018'] = $cell->getCalculatedValue();
	}
	
	return $array_data;
}
add_action('wp_ajax_importExcelTC', 'importExcelTC');
add_action('wp_ajax_nopriv_importExcelTC', 'importExcelTC');

function importExcelIE($inputFileName3){
	// library
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel5.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel2007.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/IOFactory.php');

	// $inputFileName = get_template_directory().'/IE.xlsx';
	$inputFileName = $inputFileName3;
	

	//  Read your Excel workbook
	try {
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
	} catch(Exception $e) {
		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	$objPHPExcel->setActiveSheetIndex(0);
	$sheet = $objPHPExcel ->getActiveSheet();
	$array_data = array();
	foreach($sheet->getRowIterator() as $row){
		$rowIndex = $row->getRowIndex ();
		if ($rowIndex == 1) {
			$rowIndex = $row->getRowIndex() + 1;
		}
		$array_data[$rowIndex] = array(
			'A'=>'','B'=>'', '2010'=>'', '2011'=>'', '2012'=>'',
			'2013'=>'','2014'=>'','2015'=>'','2016'=>'','2017'=>'','2018'=>'',
		);
		
		$cell = $sheet->getCell('A' . $rowIndex);
		$array_data[$rowIndex]['A'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('B' . $rowIndex);
		$array_data[$rowIndex]['B'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('M' . $rowIndex);
		$array_data[$rowIndex]['2010'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('N' . $rowIndex);
		$array_data[$rowIndex]['2011'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('O' . $rowIndex);
		$array_data[$rowIndex]['2012'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('P' . $rowIndex);
		$array_data[$rowIndex]['2013'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('Q' . $rowIndex);
		$array_data[$rowIndex]['2014'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('R' . $rowIndex);
		$array_data[$rowIndex]['2015'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('S' . $rowIndex);
		$array_data[$rowIndex]['2016'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('T' . $rowIndex);
		$array_data[$rowIndex]['2017'] = $cell->getCalculatedValue();
		$cell = $sheet->getCell('U' . $rowIndex);
		$array_data[$rowIndex]['2018'] = $cell->getCalculatedValue();
		
	}
	// print_r($array_data);
	
	return $array_data;
}
add_action('wp_ajax_importExcelIE', 'importExcelIE');
add_action('wp_ajax_nopriv_importExcelIE', 'importExcelIE');


function sizeBasedCalculation($inputFileName1){ //Расчет с учетом размера предприятия
	$array_dataRate = importExcelDA($inputFileName1);
	$array_B1 = array();
	$B1 = null;
	$array_B2 = array();
	$B2 = null;
	$array_B3 = array();
	$B3 = null;
	$DC1 = null;
	$DC2 = null;
	$DC3 = null;
	$DC = null;
	$countB = 0;
	$array_dataRateSize = count($array_dataRate);
	for ($i=0; $i < $array_dataRateSize; $i++) { 
		if ($array_dataRate[$i]['B'] == 'Малое') {
			$array_B1[$i] = $array_dataRate[$i]['AN'];
			$B1 = array_sum($array_B1);
		}
		if ($array_dataRate[$i]['B'] == 'Среднее') {
			$array_B2[$i] = $array_dataRate[$i]['AN'];
			$B2 = array_sum($array_B2);
		}
		if ($array_dataRate[$i]['B'] == 'Крупное') {
			$array_B3[$i] = $array_dataRate[$i]['AN'];
			$B3 = array_sum($array_B3);
		}
	}
	$array_B1Count = count($array_B1);
	$array_B2Count = count($array_B2);
	$array_B3Count = count($array_B3);
	if ($B1 != null) {
		$DC1 = ($B1 - 1.04 * $array_B1Count)/((5.84 * $array_B1Count)-(1.04 * $array_B1Count));
		$countB = $countB + 1;
	}
	if ($B2 != null) {
		$DC2 = ($B2 - 1.04 * $array_B2Count)/((5.84 * $array_B2Count)-(1.04 * $array_B2Count));
		$countB = $countB + 1;
	}
	if ($B3 != null) {
		$DC3 = ($B3 - 1.04 * $array_B3Count)/((5.84 * $array_B3Count)-(1.04 * $array_B3Count));
		$countB = $countB + 1;
	}
	$DC = ($B1 + $B2 + $B3) / $countB;
	// print_r($array_dataRate);
	// print_r($DC1.PHP_EOL); // малое
	// print_r($DC2.PHP_EOL); // среднее
	// print_r($DC3.PHP_EOL); // крупное
	// wp_die();
	return array($DC1,$DC2,$DC3);
	// return ['DC1' => $DC1, 'DC2' => $DC2, 'DC3' => $DC3];
	
}
add_action('wp_ajax_sizeBasedCalculation', 'sizeBasedCalculation');
add_action('wp_ajax_nopriv_sizeBasedCalculation', 'sizeBasedCalculation');

function calculationOfIndicators($inputFileName2){ // Расчет индикаторов по блокам
	$array_data = importExcelTC($inputFileName2);
	$T1 = array();
	$T2 = array();
	$T4 = array();
	$K1 = array();
	$K5FO = array();
	$I1 = array();
	$I2 = array();
	$I5 = array();
	$I6 = array();
	$BlockT = array();
	$BlockK = array();
	$BlockI = array();
	$TC = array();
	$array_years = array('2010','2011','2012','2013','2014','2015','2016','2017','2018');
	foreach ($array_years as $year) { 
		// Труд
		$T1[$year] = $array_data[2][$year] / $array_data[3][$year];
		$T2[$year] = $array_data[4][$year] / $array_data[3][$year];
		$T4[$year] = $array_data[5][$year] / $array_data[6][$year];

		// Капитал
		$K1[$year] = $array_data[11][$year] / $array_data[12][$year];
		$K5FO[$year] = $array_data[17][$year];

		//Инновации
		$I1[$year] = $array_data[9][$year] / $array_data[10][$year];
		$I2[$year] = $array_data[13][$year];
		$I5[$year] = $array_data[14][$year];
		$I6[$year] = $array_data[15][$year] / $array_data[16][$year];

		$BlockT[$year] = ($T1[$year] + $T2[$year] + $T4[$year]) / 3;
		$BlockK[$year] = ($K1[$year] + $K5FO[$year]) / 2;
		$BlockI[$year] = ($I1[$year] + $I2[$year] + $I5[$year] + $I6[$year]) / 4;

		$TC[$year] = 1 / (3*($BlockT[$year] + $BlockK[$year] + $BlockI[$year]));
	}
	// print_r($array_data);
	// print_r($I6);
	// print_r($TC);
	// wp_die();
	return $TC;
}
add_action('wp_ajax_calculationOfIndicators', 'calculationOfIndicators');
add_action('wp_ajax_nopriv_calculationOfIndicators', 'calculationOfIndicators');

function institutionalEnvironment($inputFileName3){
	$array_data = importExcelIE($inputFileName3);
	$NA = array();
	$TAX = array();
	$t = array();
	$IE = array();
	$array_years = array('2010','2011','2012','2013','2014','2015','2016','2017','2018');
	foreach($array_years as $year){
		$IE[$year] = 1 / (3 * ($array_data[3][$year] + (1 - $array_data[4][$year]) + (1 - $array_data[5][$year])));
	}
	// print_r($IE);
	// wp_die();
	return $IE;
}
add_action('wp_ajax_institutionalEnvironment', 'institutionalEnvironment');
add_action('wp_ajax_nopriv_institutionalEnvironment', 'institutionalEnvironment');

function calcInnovativePotential(){
	$inputFileName1 = $_FILES['file_0']['tmp_name'];
	$inputFileName2 = $_FILES['file_1']['tmp_name'];
	$inputFileName3 = $_FILES['file_2']['tmp_name'];
	
	// echo $inputFileName2;
	// $inputValueDC = $_POST['valueDC'];
	// $inputFileName1 = $_FILES['File01']['inputFileName1'];
	// $inputFileName2 = $_FILES['File02']['inputFileName2'];
	// $inputFileName3 = $_FILES['File03']['inputFileName3'];
	// $inputValueDC = $_POST['valueDC'];
	// print_r($inputFileName1);
	

	list($DC1, $DC2, $DC3) = sizeBasedCalculation($inputFileName1); // Динамические способности с учетом размера предприятия
	
	$TC = calculationOfIndicators($inputFileName2); // Технологические возможности
	$IE = institutionalEnvironment($inputFileName3); // Институциональная среда
	$IA = array(13.0, 13.3, 13.4, 13.3, 13.6, 13.3, 13.3, 15.1, 14.2);
	$IAsize = count($IA);
	$array_years = array('2010','2011','2012','2013','2014','2015','2016','2017','2018');
	$array_yearsPrognoz = array('2010','2011','2012','2013','2014','2015','2016',
	'2017','2018','2019','2020','2021','2022','2023','2024','2025');
	$IP_small = array(); // иновационный потенциал малых предприятий
	$IP_average = array(); // иновационный потенциал средних предприятий
	$IP_big = array(); // иновационный потенциал крупных предприятий
	$Ytemp = array();
	$Y = array();
	$flagFirstElem = false;
		for($i = 0; $i < $IAsize; $i++){
			if ($flagFirstElem == false) {
				
				$Ytemp[$i] = $IA[0];
				$flagFirstElem = true;
			} else {
				$Ytemp[$i] = (($IA[$i] - $IA[$i - 1]) * ($IA[$i] - $IA[$i - 1])) / $IA[$i - 1];
			}
		}	
	$Y = array_combine($array_years, $Ytemp);
	foreach($array_years as $years){
		$IP_small[$years] = ($TC[$years] + $DC1 + $IE[$years]) / $Y[$years];
		$IP_average[$years] = ($TC[$years] + $DC2 + $IE[$years]) / $Y[$years];
		$IP_big[$years] = ($TC[$years] + $DC3 + $IE[$years]) / $Y[$years];
	}
	// print_r($IP_small); // Иновационный потенциал малых предприятий
	// print_r($IP_average); // Иновационный потенциал средних предприятий
	// print_r($IP_big); // Иновационный потенциал крупных предприятий
	// echo $IP_small, $IP_average, $IP_big;
	print_r($IP_small);
	print_r($IP_average);
	print_r($IP_big);
	wp_die();
	
}
add_action('wp_ajax_calcInnovativePotential', 'calcInnovativePotential');
add_action('wp_ajax_nopriv_calcInnovativePotential', 'calcInnovativePotential');







/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

