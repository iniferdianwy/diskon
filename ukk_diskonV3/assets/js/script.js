document.addEventListener("DOMContentLoaded", function () {
    const hargaInput = document.getElementById("harga");
    const diskonInput = document.getElementById("diskon");
    const hargaSetelahDiskonInput = document.getElementById("harga_setelah_diskon");
    const konfirmasiDiskonBtn = document.getElementById("konfirmasiDiskon");

    konfirmasiDiskonBtn.addEventListener("click", function () {
        const harga = parseFloat(hargaInput.value);
        const diskon = parseFloat(diskonInput.value);

        if (!isNaN(harga) && !isNaN(diskon) && diskon >= 0 && diskon <= 100) {
            const hargaSetelahDiskon = harga - (harga * (diskon / 100));
            hargaSetelahDiskonInput.value = "Rp" + hargaSetelahDiskon.toLocaleString("id-ID");
        } else {
            alert("Masukkan harga dan diskon dengan benar!");
        }
    });
});