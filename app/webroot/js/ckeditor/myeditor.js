$editors = {};
function setCkeditor($element){
	ClassicEditor
		.create( document.querySelector( $element ), {

			toolbar: {
				items: [
					'sourceEditing',
					'|',
					'bold',
					'italic',
					'link',
					'bulletedList',
					'numberedList',
					'|',
					'fontColor',
					'fontBackgroundColor',
					'|',
					'outdent',
					'indent',
					'|',
					'horizontalLine',
					'blockQuote',
					'insertTable',
					'mediaEmbed'
				]
			},
			language: 'ja',
			table: {
				contentToolbar: [
					'tableColumn',
					'tableRow',
					'mergeTableCells'
				]
			},
			licenseKey: '',
		} )
		.then( editor => {
			$editors[$element] = editor;
		} )
		.catch( error => {
			console.error( 'Oops, something went wrong!' );
			console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
			console.warn( 'Build id: lkknqgycz77j-jq54diu1fmz' );
			console.error( error );
		} );
}
$(function (){
	$('.sourceView').click(function (e){
		$theElement = $(e.currentTarget).data("editor");
		alert($editors[$theElement].getData());
	})

	$('.inputEnter').click(function (e){
		$theElement = $(e.currentTarget).data("editor");
		$editors[$theElement].execute( 'enter' );
	})

	$('.inputTicketInfo').click(function (e){
		$theElement = $(e.currentTarget).data("editor");
		$theUrl = $(e.currentTarget).data("url");

		$editors[$theElement].setData( '<p>\n' +
			'    全席指定：円（税込）\n' +
			'</p>\n' +
			'<ul>\n' +
			'    <li>\n' +
			'        Hakuju Hall チケットセンター\n' +
			'        <br>\n' +
			'        <a href="tel:0354788700">03-5478-8700</a>\n' +
			'    </li>\n' +
			'    <li>\n' +
			'        <a href="https://' + $theUrl + '">Hakuju Hall オンラインチケット予約</a>\n' +
			'    </li>\n' +
			'    <li>\n' +
			'        <a href="https://l-tike.com">ローソンチケット</a>\n' +
			'    </li>\n' +
			'    <li>\n' +
			'        <a href="https://eplus.jp">イープラス</a>\n' +
			'    </li>\n' +
			'</ul>\n' +
			'<p>\n' +
			'    2021年月日()発売\n' +
			'</p>' );
	})

	$('#inputTicketCenter').click(function (e){
		$theElement = $(e.currentTarget).data("editor");
		$editors[$theElement].setData( '<p>\n' +
			'    Hakuju Hall チケットセンター\n' +
			'    <br>\n' +
			'    <a href="tel:0354788700">03-5478-8700</a>\n' +
			'    <br>\n' +
			'    <br>\n' +
			'    &nbsp;\n' +
			'</p>' );
	})

	$('#details_free_date_button').click(function (e){
		$theElement = $(e.currentTarget).data("editor");
		$editors[$theElement].setData( '<p>\n' +
			'    <span style="color:hsl(0,75%,60%);"><strong>【公演中止】</strong></span>\n' +
			'    <br>\n' +
			'    <strong>年月日（）</strong> 00：00開演（00：00開場）\n' +
			'    <br>\n' +
			'    　全席指定0,000円（税込）\n' +
			'    <br>\n' +
			'    <br>\n' +
			'    <span style="color:hsl(210,75%,60%);"><strong>【次回公演予定】</strong></span>\n' +
			'    <br>\n' +
			'    <strong>年月日（）</strong> 00：00開演\n' +
			'    <br>\n' +
			'    <span style="color:hsl(0,0%,30%);">※お手持ちのチケットではご入場いただけませんのでご注意下さい。</span>\n' +
			'    <br>\n' +
			'    <span style="color:hsl(0,0%,30%);">　チケット発売等の詳細につきましては、決まり次第当HP等で発表いたします。</span>\n' +
			'</p>' );
	})

	$('#details_free_side_button').click(function (e){
		$theElement = $(e.currentTarget).data("editor");
		$editors[$theElement].setData( '<p>\n' +
			'    <a href="/pdf/top/refund250.pdf"><span style="background-color:hsl(0,75%,60%);color:hsl(0,0%,100%);">&nbsp;払い戻し方法について&nbsp;</span></a>\n' +
			'</p>\n' +
			'<p>\n' +
			'    <span style="background-color:hsl(240, 75%, 60%);color:hsl(0, 0%, 100%);">&nbsp;</span><a href="https://l-tike.com/st1/hakujuonline02"><span style="background-color:hsl(240, 75%, 60%);color:hsl(0, 0%, 100%);">Hakuju Hall オンラインで購入の方</span></a><span style="background-color:hsl(240, 75%, 60%);color:hsl(0, 0%, 100%);">&nbsp;</span>\n' +
			'</p>\n' +
			'<hr>\n' +
			'<p>\n' +
			'    <span style="background-color:hsl(0, 0%, 30%);color:hsl(0, 0%, 100%);">&nbsp;電話&nbsp;</span> Hakuju Hallチケットセンター\n' +
			'    <br>\n' +
			'    <a href="tel:0354788700">03-5478-8700</a>\n' +
			'    <br>\n' +
			'    <br>\n' +
			'    11:00から〜17:00\n' +
			'    <br>\n' +
			'    火〜金（祝日・休館日を除く）\n' +
			'</p>' );
		alert('「払い戻し方法について」のリンク先は一つ一つ違います。リンクし直すようにしてください。');
	})

	$('#addPdf').click(function (e){
		$pdffile = $(e.currentTarget).data("pdffile");
		$theElement = $(e.currentTarget).data("editor");
		$theData = $editors[$theElement].getData();
		$editors[$theElement].setData($theData + '<a href="/img/notice/' + $pdffile + '">PDFをダウンロード</a>');
	})
})
