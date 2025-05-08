document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("fileInput");

    if (!fileInput) {
        console.error("File input element not found");
        return;
    }

    fileInput.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (!file) {
            alert("No file selected.");
            return;
        }

        console.log("File selected:", file.name);
        const reader = new FileReader();

        reader.onload = function (e) {
            const buffer = e.target.result;
            const view = new DataView(buffer);

            const temp = view.getFloat32(0, false).toFixed(2);
            const battery = view.getUint8(5);
            const text = new TextDecoder().decode(new Uint8Array(buffer, 8));
            const parts = text.split("|");

            const name = parts[0] || "Unknown";
            const lat = parts[1] || "--";
            const long = parts[2] || "--";

            document.getElementById("satName").textContent = name;
            document.getElementById("temperature").textContent = `${temp} °C`;
            document.getElementById("battery").textContent = `${battery} %`;
            document.getElementById("location").textContent = `${lat}, ${long}`;
        };

        reader.readAsArrayBuffer(file);
    });
});
