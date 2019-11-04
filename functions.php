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
	wp_enqueue_style( 'innovativepotential-style', get_stylesheet_uri() );

	wp_enqueue_script( 'innovativepotential-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery-script', get_template_directory_uri() .'/js/jquery-3.4.1.min.js' , array(), null, false );

	wp_enqueue_script( 'innovativepotential-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'general-script', get_template_directory_uri() .'/js/general.js' , array(), null, false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'innovativepotential_scripts' );


function importExcel()
{
	// library
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel5.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/Writer/Excel2007.php');
	include_once(get_template_directory() . '/inc/PHPExcel/PHPExcel/IOFactory.php');


	$inputFileName = get_template_directory().'/BD.xlsx';
	

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
	// print_r($array_x);
	$countString = $rowIndex - 2;

	// print_r($array_dataRate);
	$array_B1 = array();
	$B1 = null;
	$array_B2 = array();
	$B2 = null;
	$array_B3 = array();
	$B3 = null;
	for ($i=0; $i < $array_dataRateSize; $i++) { 
		if ($array_dataRate[$i]['A'] == 'Частная' && $array_dataRate[$i]['B'] == 'Малое') {
			$array_B1[$i] = $array_dataRate[$i]['AN'];
			$B1 = array_sum($array_B1);
		} 
		if ($array_dataRate[$i]['A'] == 'Частная' && $array_dataRate[$i]['B'] == 'Среднее'){
			$array_B2[$i] = $array_dataRate[$i]['AN'];
			$B2 = array_sum($array_B2);
		}
		if ($array_dataRate[$i]['A'] == 'Частная' && $array_dataRate[$i]['B'] == 'Крупное'){
			$array_B3[$i] = $array_dataRate[$i]['AN'];
			$B3 = array_sum($array_B3);
		}
	}
	// print_r($B1);
	// print_r($array_B1);
	// print_r($B2);
	// print_r($array_B2);
	// print_r($B3);
	// print_r($array_B3);
	$array_B1Count = count($array_B1);
	$array_B2Count = count($array_B2);
	$array_B3Count = count($array_B3);

	$DC1 = ($B1 - 1.04 * $array_B1Count)/((5.84 * $array_B1Count)-(1.04 * $array_B1Count));
	$DC2 = ($B2 - 1.04 * $array_B2Count)/((5.84 * $array_B2Count)-(1.04 * $array_B2Count));
	$DC3 = ($B3 - 1.04 * $array_B3Count)/((5.84 * $array_B3Count)-(1.04 * $array_B3Count));
	print_r($DC1 . '\n');
	print_r($DC2 . '\n');
	print_r($DC3);

}
add_action('wp_ajax_importExcel', 'importExcel');
add_action('wp_ajax_nopriv_importExcel', 'importExcel');











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

