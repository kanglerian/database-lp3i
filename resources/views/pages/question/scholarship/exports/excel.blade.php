<script src="{{ asset('js/exceljs.min.js') }}"></script>
<script>
    const exportExcel = async () => {
        try {
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Data');
            let header = ['Nama Lengkap', 'Presenter', 'Asal Sekolah', 'Analisa', 'Kuantitatif',
                'Bahasa Inggris', 'Nilai Analisa', 'Nilai Kuantitatif', 'Nilai Bahasa Inggris',
                'Nilai Akhir'
            ];
            let dataExcel = [
                header,
            ];
            data.forEach(student => {
                let analisa = student.detail.find((content) => content.category == 'Kemampuan Analisa');
                let kuantitatif = student.detail.find((content) => content.category ==
                    'Kemampuan Kuantitatif');
                let inggris = student.detail.find((content) => content.category == 'Bahasa Inggris');
                let studentBucket = [];
                let analisaScore = analisa ? parseInt(analisa.score) : 0;
                let kuantitatifScore = kuantitatif ? parseInt(kuantitatif.score) : 0;
                let inggrisScore = inggris ? parseInt(inggris.score) : 0;
                let finalRecord = (analisaScore + kuantitatifScore + inggrisScore) / 3;
                studentBucket.push(
                    `${student.identity ? student.identity.name : 'Tidak'}`,
                    `${student.identity ? student.identity.presenter.name : 'Tidak'}`,
                    `${student.identity ? student.identity.school_applicant.name : 'Tidak'}`,
                    `${analisa == undefined ? 'Belum mengerjakan' : analisa.trueResult}`,
                    `${kuantitatif == undefined ? 'Belum mengerjakan' : kuantitatif.trueResult}`,
                    `${inggris == undefined ? 'Belum mengerjakan' : inggris.trueResult}`,
                    `${analisa == undefined ? 'Belum mengerjakan' : analisa.score}`,
                    `${kuantitatif == undefined ? 'Belum mengerjakan' : kuantitatif.score}`,
                    `${inggris == undefined ? 'Belum mengerjakan' : inggris.score}`,
                    `${finalRecord.toFixed()}`
                );
                dataExcel.push(studentBucket);
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
