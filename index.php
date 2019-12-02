<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package innovativePotential
 */

get_header();
?>

	<div class='container'>
		<div class='row'>
			<form id='form'>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Upload</span>
					</div>
					<div class="custom-file ">
						<input type="file" class="custom-file-input js-add-file" multiple id="inputGroupFile01" name="File01">
						<label class="custom-file-label" for="inputGroupFile01">Выберите таблицу ДС</label>
					</div>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Upload</span>
					</div>
					<div class="custom-file ">
						<input type="file" class="custom-file-input  js-add-file" multiple id="inputGroupFile02" name="File02">
						<label class="custom-file-label" for="inputGroupFile02">Выберите таблицу ТВ</label>
					</div>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Upload</span>
					</div>
					<div class="custom-file">
						<input type="file" class="custom-file-input  js-add-file" multiple id="inputGroupFile03" name="File03">
						<label class="custom-file-label" for="inputGroupFile03">Выберите таблицу ИС</label>
					</div>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Прогнозное значение</label>
					<input type="text" class="form-control" id="inputNumbers" aria-describedby="inputNumbersHelp" name="valueDC">
					<small id="inputNumbersHelp" class="form-text text-muted">Введите прогнозные значения с 2019 по 2025 через ;</small>
  				</div>
				
				<button id='button-submit' type="" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>

<?php
get_sidebar();
get_footer();
