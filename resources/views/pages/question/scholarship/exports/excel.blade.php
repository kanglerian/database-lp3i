<script src="{{ asset('js/exceljs.min.js') }}"></script>
<script>
    const exportExcel = async () => {
        try {
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Data');
            let header = ['No', 'Tanggal', 'Nama Lengkap', 'Presenter', 'Asal Sekolah', 'Total Benar', 'Nilai Akhir'];
            let dataExcel = [
                header,
            ];
            dataScholarship.forEach((data, index) => {
                let bucket = [];
                bucket.push(
                    `${index + 1}`,
                    `${data.date || 'Tidak diketahui'}`,
                    `${data.name}`,
                    `${data.presenter}`,
                    `${data.school}`,
                    `${data.trueScore}`,
                    `${data.total}`
                );
                dataExcel.push(bucket);
            });

            worksheet.addRows(dataExcel);

            // Create a Blob from the Excel workbook
            const blob = await workbook.xlsx.writeBuffer();
            const blobData = new Blob([blob], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blobData);
            link.download = 'hasil-sbpmb-online.xlsx';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            console.log('File Excel berhasil dibuat: hasil-sbpmb-online.xlsx');
        } catch (error) {
            console.error('Error:', error);
        }
    };
</script>
