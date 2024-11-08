<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WHOIS Sorgulama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Domain WHOIS Sorgulama</h2>

        <?php
        // PHP hata raporlamasını aç
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Veritabanı bağlantısı
        $conn = new mysqli('localhost', 'whois', '14hi9LVezUtJj583oBLe', 'whois');
        if ($conn->connect_error) {
            die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['domains'])) {
            $domains = $_POST['domains'];
            $tlds = $_POST['tlds'] ?? []; // Eğer tlds yoksa boş array yap
            if (!is_array($tlds)) $tlds = []; // Eğer tlds bir array değilse, onu array yap

            foreach ($domains as $index => $domain) {
                $domain = trim($domain);
                $tld = isset($tlds[$index]) ? trim($tlds[$index]) : '';

                if (!empty($domain) && !empty($tld)) {
                    $fullDomain = $domain . "." . $tld;

                    $whoisData = whoisQuery($fullDomain, $conn);

                    // Domain durumu kontrolü (domain kayıtlı mı, boşta mı?)
                    $available = strpos($whoisData, 'No match') !== false ? 'Domain boşta' : 'Domain kayıtlı';

                    // Verileri tablo içinde gösterme
                    $registrar = parseWhoisData($whoisData, 'Registrar');
                    $creationDate = parseWhoisData($whoisData, 'Creation Date');
                    $expiryDate = parseWhoisData($whoisData, 'Registry Expiry Date');
                    $status = parseWhoisData($whoisData, 'Domain Status');
                    $nameservers = parseWhoisData($whoisData, 'Name Server');
                    $dnssec = parseWhoisData($whoisData, 'DNSSEC');
                    $owner = parseWhoisData($whoisData, 'Registrant Name');
                    $ownerEmail = parseWhoisData($whoisData, 'Registrant Email');
                    $ownerPhone = parseWhoisData($whoisData, 'Registrant Phone');

                    echo '<h3 class="mt-5">Sorgu Sonuçları: ' . htmlspecialchars($fullDomain) . '</h3>';
                    echo '<p><strong>' . $available . '</strong></p>';
                    echo '<table class="table table-striped mt-3">
                            <tr><th>Registrar</th><td>' . $registrar . '</td></tr>
                            <tr><th>Kayıt Tarihi</th><td>' . $creationDate . '</td></tr>
                            <tr><th>Bitiş Tarihi</th><td>' . $expiryDate . '</td></tr>
                            <tr><th>Durum</th><td>' . $status . '</td></tr>
                            <tr><th>DNSSEC</th><td>' . $dnssec . '</td></tr>
                            <tr><th>Ad Sunucuları</th><td>' . $nameservers . '</td></tr>
                            <tr><th>Sahibi</th><td>' . $owner . '</td></tr>
                            <tr><th>Sahip E-posta</th><td>' . $ownerEmail . '</td></tr>
                            <tr><th>Sahip Telefon</th><td>' . $ownerPhone . '</td></tr>
                          </table>';
                }
            }
        }
        ?>

        <form method="POST" action="">
            <table class="table table-bordered" id="domainTable">
                <thead>
                    <tr>
                        <th></th> <!-- Domain ekleme butonu için boş sütun -->
                        <th>Domain Adı</th>
                        <th>TLD Seçin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><button type="button" class="btn btn-success btn-sm" id="addRow">+</button></td>
                        <td><input type="text" class="form-control" name="domains[]" placeholder="example" required></td>
                        <td>
                            <select class="form-select tld-select" name="tlds[]">
                                <option value="com">.com</option>
                                <option value="net">.net</option>
                                <option value="org">.org</option>
                                <option value="io">.io</option>
                                <option value="co">.co</option>
                                <option value="info">.info</option>
                                <option value="ac">.ac</option>
                                <option value="ad">.ad</option>
                                <option value="ae">.ae</option>
                                <option value="aero">.aero</option>
                                <option value="af">.af</option>
                                <option value="ag">.ag</option>
                                <option value="ai">.ai</option>
                                <option value="al">.al</option>
                                <option value="am">.am</option>
                                <option value="as">.as</option>
                                <option value="asia">.asia</option>
                                <option value="at">.at</option>
                                <option value="au">.au</option>
                                <option value="aw">.aw</option>
                                <option value="ax">.ax</option>
                                <option value="az">.az</option>
                                <option value="ba">.ba</option>
                                <option value="bar">.bar</option>
                                <option value="be">.be</option>
                                <option value="berlin">.berlin</option>
                                <option value="best">.best</option>
                                <option value="bg">.bg</option>
                                <option value="bi">.bi</option>
                                <option value="biz">.biz</option>
                                <option value="bj">.bj</option>
                                <option value="bo">.bo</option>
                                <option value="br">.br</option>
                                <option value="br.com">.br.com</option>
                                <option value="bt">.bt</option>
                                <option value="bw">.bw</option>
                                <option value="by">.by</option>
                                <option value="bz">.bz</option>
                                <option value="bzh">.bzh</option>
                                <option value="ca">.ca</option>
                                <option value="cat">.cat</option>
                                <option value="cc">.cc</option>
                                <option value="cd">.cd</option>
                                <option value="ceo">.ceo</option>
                                <option value="cf">.cf</option>
                                <option value="ch">.ch</option>
                                <option value="ci">.ci</option>
                                <option value="cl">.cl</option>
                                <option value="cloud">.cloud</option>
                                <option value="club">.club</option>
                                <option value="coop">.coop</option>
                                <option value="cx">.cx</option>
                                <option value="cz">.cz</option>
                                <option value="de">.de</option>
                                <option value="dk">.dk</option>
                                <option value="dm">.dm</option>
                                <option value="dz">.dz</option>
                                <option value="ec">.ec</option>
                                <option value="ee">.ee</option>
                                <option value="es">.es</option>
                                <option value="eu">.eu</option>
                                <option value="fi">.fi</option>
                                <option value="fm">.fm</option>
                                <option value="fr">.fr</option>
                                <option value="ga">.ga</option>
                                <option value="gd">.gd</option>
                                <option value="gg">.gg</option>
                                <option value="gl">.gl</option>
                                <option value="gov">.gov</option>
                                <option value="gs">.gs</option>
                                <option value="hk">.hk</option>
                                <option value="hm">.hm</option>
                                <option value="hn">.hn</option>
                                <option value="hr">.hr</option>
                                <option value="hu">.hu</option>
                                <option value="ie">.ie</option>
                                <option value="il">.il</option>
                                <option value="im">.im</option>
                                <option value="in">.in</option>
                                <option value="io">.io</option>
                                <option value="iq">.iq</option>
                                <option value="ir">.ir</option>
                                <option value="is">.is</option>
                                <option value="it">.it</option>
                                <option value="je">.je</option>
                                <option value="jp">.jp</option>
                                <option value="ke">.ke</option>
                                <option value="kg">.kg</option>
                                <option value="ki">.ki</option>
                                <option value="kr">.kr</option>
                                <option value="kz">.kz</option>
                                <option value="la">.la</option>
                                <option value="lt">.lt</option>
                                <option value="lu">.lu</option>
                                <option value="lv">.lv</option>
                                <option value="ly">.ly</option>
                                <option value="ma">.ma</option>
                                <option value="mc">.mc</option>
                                <option value="md">.md</option>
                                <option value="me">.me</option>
                                <option value="mg">.mg</option>
                                <option value="mk">.mk</option>
                                <option value="ml">.ml</option>
                                <option value="mn">.mn</option>
                                <option value="mo">.mo</option>
                                <option value="ms">.ms</option>
                                <option value="mt">.mt</option>
                                <option value="mu">.mu</option>
                                <option value="mx">.mx</option>
                                <option value="my">.my</option>
                                <option value="mz">.mz</option>
                                <option value="na">.na</option>
                                <option value="name">.name</option>
                                <option value="nc">.nc</option>
                                <option value="nf">.nf</option>
                                <option value="ng">.ng</option>
                                <option value="nl">.nl</option>
                                <option value="no">.no</option>
                                <option value="nu">.nu</option>
                                <option value="nz">.nz</option>
                                <option value="pa">.pa</option>
                                <option value="pe">.pe</option>
                                <option value="pf">.pf</option>
                                <option value="pl">.pl</option>
                                <option value="pm">.pm</option>
                                <option value="post">.post</option>
                                <option value="pr">.pr</option>
                                <option value="pt">.pt</option>
                                <option value="pw">.pw</option>
                                <option value="qa">.qa</option>
                                <option value="re">.re</option>
                                <option value="ro">.ro</option>
                                <option value="rs">.rs</option>
                                <option value="ru">.ru</option>
                                <option value="sa">.sa</option>
                                <option value="sb">.sb</option>
                                <option value="sc">.sc</option>
                                <option value="se">.se</option>
                                <option value="sg">.sg</option>
                                <option value="sh">.sh</option>
                                <option value="si">.si</option>
                                <option value="sk">.sk</option>
                                <option value="sm">.sm</option>
                                <option value="st">.st</option>
                                <option value="su">.su</option>
                                <option value="sx">.sx</option>
                                <option value="sy">.sy</option>
                                <option value="tc">.tc</option>
                                <option value="tf">.tf</option>
                                <option value="th">.th</option>
                                <option value="tj">.tj</option>
                                <option value="tk">.tk</option>
                                <option value="tl">.tl</option>
                                <option value="tm">.tm</option>
                                <option value="tn">.tn</option>
                                <option value="to">.to</option>
                                <option value="tr">.tr</option>
                                <option value="tt">.tt</option>
                                <option value="tv">.tv</option>
                                <option value="tw">.tw</option>
                                <option value="tz">.tz</option>
                                <option value="ua">.ua</option>
                                <option value="ug">.ug</option>
                                <option value="uk">.uk</option>
                                <option value="us">.us</option>
                                <option value="uy">.uy</option>
                                <option value="uz">.uz</option>
                                <option value="vc">.vc</option>
                                <option value="ve">.ve</option>
                                <option value="vg">.vg</option>
                                <option value="ws">.ws</option>
                                <option value="za">.za</option>
                                <option value="zm">.zm</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Sorgula</button>
        </form>

        <?php
        // WHOIS sorgusunu gerçekleştiren fonksiyon
        function whoisQuery($domain, $conn) {
            $domain = $conn->real_escape_string($domain);

            // Önce veritabanında önbellek kontrolü
            $result = $conn->query("SELECT whois_data, last_checked FROM whois_cache WHERE domain = '$domain'");
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $timeElapsed = time() - strtotime($row['last_checked']);
                if ($timeElapsed < 86400) { // 24 saatlik önbellek süresi
                    return $row['whois_data'];
                }
            }

            // WHOIS sorgusu yap ve sonuçları önbelleğe kaydet
            $whoisData = performWhoisQuery($domain);

            // SQL enjeksiyon önlemek için özel karakterleri kaçır
            $whoisData = $conn->real_escape_string($whoisData);

            if ($conn->query("REPLACE INTO whois_cache (domain, whois_data) VALUES ('$domain', '$whoisData')") === FALSE) {
                die("Veritabanına veri eklenemedi: " . $conn->error);
            }

            return $whoisData;
        }

        // WHOIS sunucusundan sorgu yapan fonksiyon
        function performWhoisQuery($domain) {
           $whoisServers = [
                "ac" => "whois.nic.ac",
                "ad" => "whois.ripe.net",
                "ae" => "whois.aeda.net.ae",
                "aero" => "whois.aero",
                "af" => "whois.nic.af",
                "ag" => "whois.nic.ag",
                "ai" => "whois.ai",
                "al" => "whois.ripe.net",
                "am" => "whois.amnic.net",
                "as" => "whois.nic.as",
                "asia" => "whois.nic.asia",
                "at" => "whois.nic.at",
                "au" => "whois.aunic.net",
                "aw" => "whois.nic.aw",
                "ax" => "whois.ax",
                "az" => "whois.ripe.net",
                "ba" => "whois.ripe.net",
                "bar" => "whois.nic.bar",
                "be" => "whois.dns.be",
                "berlin" => "whois.nic.berlin",
                "best" => "whois.nic.best",
                "bg" => "whois.register.bg",
                "bi" => "whois.nic.bi",
                "biz" => "whois.neulevel.biz",
                "bj" => "www.nic.bj",
                "bo" => "whois.nic.bo",
                "br" => "whois.nic.br",
                "br.com" => "whois.centralnic.com",
                "bt" => "whois.netnames.net",
                "bw" => "whois.nic.net.bw",
                "by" => "whois.cctld.by",
                "bz" => "whois.belizenic.bz",
                "bzh" => "whois-bzh.nic.fr",
                "ca" => "whois.cira.ca",
                "cat" => "whois.cat",
                "cc" => "whois.nic.cc",
                "cd" => "whois.nic.cd",
                "ceo" => "whois.nic.ceo",
                "cf" => "whois.dot.cf",
                "ch" => "whois.nic.ch",
                "ci" => "whois.nic.ci",
                "cl" => "whois.nic.cl",
                "cloud" => "whois.nic.cloud",
                "club" => "whois.nic.club",
                "com" => "whois.verisign-grs.com",
                "net" => "whois.verisign-grs.com",
                "org" => "whois.pir.org",
                "coop" => "whois.nic.coop",
                "cx" => "whois.nic.cx",
                "cz" => "whois.nic.cz",
                "de" => "whois.denic.de",
                "dk" => "whois.dk-hostmaster.dk",
                "dm" => "whois.nic.dm",
                "dz" => "whois.nic.dz",
                "ec" => "whois.nic.ec",
                "ee" => "whois.eenet.ee",
                "es" => "whois.nic.es",
                "eu" => "whois.eu",
                "fi" => "whois.fi",
                "fm" => "whois.nic.fm",
                "fr" => "whois.nic.fr",
                "ga" => "whois.galacticregistry.ga",
                "gd" => "whois.nic.gd",
                "gg" => "whois.gg",
                "gl" => "whois.nic.gl",
                "gov" => "whois.dotgov.gov",
                "gs" => "whois.nic.gs",
                "hk" => "whois.hkirc.hk",
                "hm" => "whois.registry.hm",
                "hn" => "whois.nic.hn",
                "hr" => "whois.dns.hr",
                "hu" => "whois.nic.hu",
                "ie" => "whois.iedr.ie",
                "il" => "whois.isoc.org.il",
                "im" => "whois.nic.im",
                "in" => "whois.inregistry.net",
                "io" => "whois.nic.io",
                "iq" => "whois.cmc.iq",
                "ir" => "whois.nic.ir",
                "is" => "whois.isnic.is",
                "it" => "whois.nic.it",
                "je" => "whois.je",
                "jp" => "whois.jprs.jp",
                "ke" => "whois.kenic.or.ke",
                "kg" => "www.domain.kg",
                "ki" => "whois.nic.ki",
                "kr" => "whois.kr",
                "kz" => "whois.nic.kz",
                "la" => "whois.nic.la",
                "lt" => "whois.domreg.lt",
                "lu" => "whois.dns.lu",
                "lv" => "whois.nic.lv",
                "ly" => "whois.nic.ly",
                "ma" => "whois.iam.net.ma",
                "mc" => "whois.ripe.net",
                "md" => "whois.nic.md",
                "me" => "whois.nic.me",
                "mg" => "whois.nic.mg",
                "mk" => "whois.marnet.mk",
                "ml" => "whois.dot.ml",
                "mn" => "whois.nic.mn",
                "mo" => "whois.monic.mo",
                "ms" => "whois.nic.ms",
                "mt" => "whois.nic.org.mt",
                "mu" => "whois.nic.mu",
                "mx" => "whois.mx",
                "my" => "whois.mynic.my",
                "mz" => "whois.nic.mz",
                "na" => "whois.na-nic.com.na",
                "name" => "whois.nic.name",
                "nc" => "whois.nc",
                "nf" => "whois.nic.nf",
                "ng" => "whois.nic.net.ng",
                "nl" => "whois.domain-registry.nl",
                "no" => "whois.norid.no",
                "nu" => "whois.nic.nu",
                "nz" => "whois.srs.net.nz",
                "pa" => "whois.nic.pa",
                "pe" => "kero.yachay.pe",
                "pf" => "whois.registry.pf",
                "pl" => "whois.dns.pl",
                "pm" => "whois.nic.pm",
                "post" => "whois.dotpostregistry.net",
                "pr" => "whois.nic.pr",
                "pt" => "whois.dns.pt",
                "pw" => "whois.nic.pw",
                "qa" => "whois.registry.qa",
                "re" => "whois.nic.re",
                "ro" => "whois.rotld.ro",
                "rs" => "whois.rnids.rs",
                "ru" => "whois.tcinet.ru",
                "sa" => "whois.nic.net.sa",
                "sb" => "whois.nic.net.sb",
                "sc" => "whois2.afilias-grs.net",
                "se" => "whois.iis.se",
                "sg" => "whois.sgnic.sg",
                "sh" => "whois.nic.sh",
                "si" => "whois.arnes.si",
                "sk" => "whois.sk-nic.sk",
                "sm" => "whois.nic.sm",
                "st" => "whois.nic.st",
                "su" => "whois.tcinet.ru",
                "sx" => "whois.sx",
                "sy" => "whois.tld.sy",
                "tc" => "whois.meridiantld.net",
                "tf" => "whois.nic.tf",
                "th" => "whois.thnic.co.th",
                "tj" => "whois.nic.tj",
                "tk" => "whois.dot.tk",
                "tl" => "whois.nic.tl",
                "tm" => "whois.nic.tm",
                "tn" => "whois.ati.tn",
                "to" => "whois.tonic.to",
                "tr" => "whois.nic.tr",
                "tt" => "whois.nic.tt",
                "tv" => "whois.nic.tv",
                "tw" => "whois.twnic.net.tw",
                "tz" => "whois.tznic.or.tz",
                "ua" => "whois.ua",
                "ug" => "whois.co.ug",
                "uk" => "whois.nic.uk",
                "us" => "whois.nic.us",
                "uy" => "whois.nic.org.uy",
                "uz" => "whois.cctld.uz",
                "vc" => "whois2.afilias-grs.net",
                "ve" => "whois.nic.ve",
                "vg" => "whois.adamsnames.tc",
                "ws" => "whois.website.ws",
                "za" => "whois.registry.net.za",
                "zm" => "whois.nic.zm"
            ];

            $domainParts = explode('.', $domain);
            $tld = array_pop($domainParts);

            if (!isset($whoisServers[$tld])) {
                return "Bu TLD için WHOIS sunucusu bulunamadı.";
            }

            $whoisServer = $whoisServers[$tld];

            $connection = fsockopen($whoisServer, 43, $errno, $errstr, 10); // 10 saniyelik zaman aşımı
            if (!$connection) {
                return "WHOIS sunucusuna bağlanılamadı: $errstr ($errno)";
            }

            fputs($connection, $domain . "\r\n");

            $whoisData = "";
            while (!feof($connection)) {
                $whoisData .= fgets($connection, 128);
            }
            fclose($connection);

            return $whoisData;
        }

        // WHOIS verisinden gerekli bilgileri regex ile ayrıştırma
        function parseWhoisData($data, $field) {
            if (preg_match("/$field:(.*)/i", $data, $match)) {
                return trim($match[1]);
            }
            return "Bulunamadı";
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Dinamik olarak yeni domain ekleme
        document.getElementById('addRow').addEventListener('click', function() {
            const table = document.getElementById('domainTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();

            const addButtonCell = newRow.insertCell(0);
            const domainCell = newRow.insertCell(1);
            const tldCell = newRow.insertCell(2);

            addButtonCell.innerHTML = '<button type="button" class="btn btn-success btn-sm" id="addRow">+</button>';
            domainCell.innerHTML = '<input type="text" class="form-control" name="domains[]" placeholder="example" required>';
            tldCell.innerHTML = `
                <select class="form-select tld-select" name="tlds[]">
                    <option value="com">.com</option>
                    <option value="net">.net</option>
                    <option value="org">.org</option>
                    <option value="io">.io</option>
                    <option value="co">.co</option>
                    <option value="info">.info</option>
                    <!-- Diğer TLD'ler buraya eklenebilir -->
                </select>`;

            // Yeni eklenen select2 kutusu için select2 uygulama
            $('.tld-select').select2();
        });

        // TLD seçim kutusuna select2 uygulama
        $('.tld-select').select2({
            placeholder: 'TLD seçin',
            allowClear: true
        });
    </script>
</body>
</html>
