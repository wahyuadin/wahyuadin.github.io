<!DOCTYPE html>
<html>
<head>
    <title>Konversi XML ke JSON</title>
</head>
<body>
    <h1>Data BMKG Jawa Barat</h1>
    <pre id="jsonOutput"></pre>

    <script>
        var xmlUrl = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaBarat.xml';

        // Menggunakan objek XMLHttpRequest untuk mengambil data XML
        var xhr = new XMLHttpRequest();
        xhr.open('GET', xmlUrl, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var xmlString = xhr.responseText;

                // Memuat data XML ke dalam objek DOMParser
                var parser = new DOMParser();
                var xmlDoc = parser.parseFromString(xmlString, 'text/xml');

                // Mengonversi objek DOM menjadi JSON
                var json = xmlToJson(xmlDoc);

                // Menampilkan data JSON
                var jsonOutput = document.getElementById('jsonOutput');
                jsonOutput.textContent = JSON.stringify(json, null, 2);
                jsonOutput.setAttribute('content-type', 'application/json');
            }
        };
        xhr.send();

        // Fungsi untuk mengonversi objek DOM menjadi JSON
        function xmlToJson(xml) {
            var obj = {};

            if (xml.nodeType === 1) {
                if (xml.attributes.length > 0) {
                    obj['@attributes'] = {};
                    for (var j = 0; j < xml.attributes.length; j++) {
                        var attribute = xml.attributes[j];
                        obj['@attributes'][attribute.nodeName] = attribute.nodeValue;
                    }
                }
            } else if (xml.nodeType === 3) {
                obj = xml.nodeValue;
            }

            if (xml.hasChildNodes()) {
                for (var i = 0; i < xml.childNodes.length; i++) {
                    var item = xml.childNodes[i];
                    var nodeName = item.nodeName;
                    if (typeof obj[nodeName] == 'undefined') {
                        obj[nodeName] = xmlToJson(item);
                    } else {
                        if (typeof obj[nodeName].push == 'undefined') {
                            var old = obj[nodeName];
                            obj[nodeName] = [];
                            obj[nodeName].push(old);
                        }
                        obj[nodeName].push(xmlToJson(item));
                    }
                }
            }
            return obj;
        }
    </script>
</body>
</html>
