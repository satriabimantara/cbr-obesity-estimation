$(document).ready(function(){
	/*INPUT DATA PAGE*/
	function inputDataTable(object){
		for (const keys in object) {
			$(object[keys].id).DataTable({
				scrollX: 550,
				scrollY: 550,
				"processing": true,
				autoWidth :false,
				buttons: [
				{
					extend :'pdfHtml5',
					className : 'btn-success',
					orientation :'landscape',
					text: '<i class="fas fa-file-pdf" aria-hidden="true"></i> PDF',
					title: object[keys].title,
					extension: ".pdf",
					filename: object[keys].filename
				}
				],
				"dom": `
				<'d-flex justify-content-between mb-3 btn-sm' fl> +
                <'d-flex justify-content-end' B>+
				<'mb-3' t> +
				<'d-flex justify-content-start mb-5 mt-3'p>
				`
			});
		}
	}
	const table = {
		table1 : {
			id : "#table_data_original",
			title : "Daftar Data Penelitian",
			filename : "Daftar Data Penelitian"
		},
		table2 : {
			id : "#table_data_normalisasi",
			title : "Daftar Data Penelitian Hasil Normalisasi",
			filename : "Daftar Data Penelitian Hasil Normalisasi"
		},
		table3 : {
			id : "#table_nilai_sse",
			title : "Daftar Nilai Sum Square Error",
			filename : "Daftar Nilai Sum Square Error"
		},
		table4 : {
			id : "#table_basis_kasus",
			title : "Daftar Basis Kasus",
			filename : "Daftar Basis Kasus"
		},
		table5 : {
			id : "#table_kasus_uji",
			title : "Daftar Kasus Uji",
			filename : "Daftar Kasus Uji"
		},
		table6 : {
			id : "#table_pengujian_kasusuji",
			title : "Daftar Hasil Pengujian Kasus Uji",
			filename : "Daftar Hasil Pengujian Kasus Uji"
		},
		table7 : {
			id : "#table_kasus_baru",
			title : "Daftar Kasus Baru",
			filename : "Daftar Kasus Baru"
		},
	};
	inputDataTable(table);
	
});