function deleteData(dataId) {
    Swal.fire({
        title: "Apakah Anda yakin ingin menghapus data ini?",
        text: "Data ini akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus saja!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Swal.fire({
            //     title: "Deleted!",
            //     text: "Your file has been deleted.",
            //     icon: "success"
            // });
            $('#deleteForm' + dataId).submit();
        }
    });
}
