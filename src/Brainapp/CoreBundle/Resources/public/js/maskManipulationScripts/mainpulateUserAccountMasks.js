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
	$('.btn-delete-account').on('click', function() {
		var accId = $(this).attr('data-accId');
		var accName = $(this).attr('data-accName');
		$('input[name="#ff_accountId"]').val(accId);
		$('.accName').html(accName);
	});
});

$(document).ready(function() {
	$('.btn-edit-account').on('click', function() {
		var accId = $(this).attr('data-accId');
		var accName = $(this).attr('data-accName');
		var accStartValue = $(this).attr('data-accStartValue');		

		if( $(this).attr('data-accIsDefaultAcc') == 1)
		{
			$('input[name="editUserAccountForm[accountIsDefaultAccount]"]').attr("checked", true);
		}
		else
		{
			$('input[name="editUserAccountForm[accountIsDefaultAccount]"]').attr("checked", false);
		}
		
		$('input[name="editUserAccountForm[accountId]"]').val(accId);
		$('input[name="editUserAccountForm[accountName]"]').val(accName);
		$('input[name="editUserAccountForm[accountStartValue]"]').val(accStartValue);
		$('.accName').html(accName);
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
