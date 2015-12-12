/*
 * Datum: 06.12.2015
 * Autor: Chris Schneider
 * -----------------------------------------------------------------------------------------------------------------------------------------
 * Dieses Script blendet Informationen zu UserCategories in den entsprechenden Masken vor.
 * 
 * Hierfür werden vor allem onClick-Events verwendet, die auf verschiedene btn-Klassen (z.B. btn-delete-cat) angewendet werden.
 * Die Daten der jeweiligen Knoten der Kategorien stammen vom data-[attribut]-Tag (z.B. data-catId), die in den HTML-Datein definiert sind.
 * 
 * > Mit diesen Daten werden zum einen Formfelder zu den Masken vorgeblendet:
 * 		- input[name="NAME_DER_MASKE[NAME_DES_ATTRIBUTS]"] für Masken, die Symfony erstellt
 * 		- input[name="#IRGENDWAS"] für Masken, die ohne Symfony erstellt werden ( z.B. input[name="#ff_categoryId"] )
 * > Außerdem werden die Daten verwendet, um statischen Text in Masken zu manipulieren
 * 		> Beispiel: $('.parentCatName').html(parentCatName);
 * -----------------------------------------------------------------------------------------------------------------------------------------
 */

$(document).ready(function() {
	$('.btn-delete-maincat').on('click', function() {
		var catId = $(this).attr('data-catId');
		var catName = $(this).attr('data-catName');
		$('input[name="#ff_categoryId"]').val(catId);
		$('.catName').html(catName);
	});
});

$(document).ready(function() {
	$('.btn-edit-maincat').on('click', function() {
		var catId = $(this).attr('data-catId');
		var catName = $(this).attr('data-catName');
		$('input[name="editUserCategoryForm[categoryId]"]').val(catId);
		$('input[name="editUserCategoryForm[categoryName]"]').val(catName);
		$('.catName').html(catName);
	});
});

$(document).ready(function() {
	$('.btn-add-maincat').on('click', function() {
		$('input[name="createUserMainCategoryForm[categoryId]"]').val("");
		$('input[name="createUserMainCategoryForm[categoryName]"]').val("");
	});
});

$(document).ready(function() {
	$('.btn-add-subcat').on('click', function() {
		var parentCatId = $(this).attr('data-catId');
		var parentCatName = $(this).attr('data-catName');
		$('input[name="createUserSubCategoryForm[parentCategoryId]"]').val(parentCatId);
		$('input[name="createUserSubCategoryForm[parentCategoryName]"]').val(parentCatName);
		$('.parentCatName').html(parentCatName);
	});
});
