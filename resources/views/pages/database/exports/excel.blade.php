<script src="{{ asset('js/exceljs.min.js') }}"></script>
<script>
    const exportExcel = async () => {

        try {
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Data');
            let header = ['No', 'Nama Lengkap', 'No. Telpon', 'Presenter', 'Asal Sekolah', 'Jurusan',
                'Tahun Lulus', 'Tipe Kelas', 'Minat Prodi', 'Sumber Database', 'Sumber Informasi'
            ];
            let dataExcel = [
                header,
            ];
            dataApplicants.forEach((student, index) => {
                let studentBucket = [];
                studentBucket.push(
                    `${index + 1}`,
                    `${student.name ? student.name : 'Tidak diketahui'}`,
                    `${student.phone ? student.phone : 'Tidak diketahui'}`,
                    `${student.identity_user ? student.presenter.name : 'Tidak diketahui'}`,
                    `${student.school ? student.school_applicant.name : 'Tidak diketahui'}`,
                    `${student.major ? student.major : 'Tidak diketahui'}`,
                    `${student.year ? student.year : 'Tidak diketahui'}`,
                    `${student.programtype_id ? student.program_type.name : 'Tidak diketahui'}`,
                    `${student.program ? student.program : 'Tidak diketahui'}`,
                    `${student.source_id ? student.source_setting.name : 'Tidak diketahui'}`,
                    `${student.source_daftar_id ? student.source_daftar_setting.name : 'Tidak diketahui'}`,
                );
                dataExcel.push(studentBucket);
            });

            let dateTime = new Date();
            const day = dateTime.getDate();
            const month = dateTime.getMonth();
            const year = dateTime.getFullYear();
            const hours = dateTime.getHours();
            const minutes = dateTime.getMinutes();
            const seconds = dateTime.getSeconds();
            const formattedDate = `export_database_${hours}${minutes}${seconds}${day}${month}${year}`;

            worksheet.addRows(dataExcel);

            const blob = await workbook.xlsx.writeBuffer();
            const blobData = new Blob([blob], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blobData);
            link.download = `${formattedDate}.xlsx`;

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

        } catch (error) {
            console.error('Error:', error);
        }
    };
</script>
