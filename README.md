# WHOIS Sorgulama Sistemi

Bu proje, kullanıcıların domain adları için WHOIS sorgulaması yapmalarını sağlayan bir web uygulamasıdır. Kullanıcılar, istedikleri domain adlarını ve ilgili TLD'leri (üst düzey alan adları) girerek sorgulama yapabilirler.

## Özellikler

- **Çoklu Domain Sorgulama**: Kullanıcılar birden fazla domain adını aynı anda sorgulayabilir.
- **TLD Seçimi**: Kullanıcılar, her bir domain için uygun TLD'yi seçebilir. Popüler TLD'ler listeden seçilebilir.
- **Dinamik Alan Ekleme**: Kullanıcılar, yeni domain alanları ekleyebilir. "+" butonuna basarak yeni bir satır açabilirler.
- **Hata Raporlama**: PHP hata raporlaması açık tutulmuş, bu sayede uygulamadaki hatalar kullanıcıya bildirilmektedir.
- **Veritabanı Entegrasyonu**: WHOIS sorgu sonuçları veritabanına kaydedilir ve önbellekleme sistemi kullanılarak tekrarlayan sorgularda performans artırılır.
- **Responsive Tasarım**: Uygulama, Bootstrap kullanılarak mobil uyumlu bir şekilde tasarlanmıştır.

## Gereksinimler

- PHP 7.0 veya üzeri
- MySQL veya MariaDB
- Bootstrap (CDN üzerinden)
- jQuery ve Select2 kütüphaneleri (CDN üzerinden)

## Kullanım

1. **Veritabanı Bağlantısı**: `whois` veritabanını oluşturun ve gerekli tabloları ekleyin.
2. **Bağlantı Bilgilerini Güncelleyin**: `index.php` dosyasında veritabanı bağlantı bilgilerinizi güncelleyin.
   ```php
   $conn = new mysqli('localhost', 'kullanici', 'sifre', 'whois');
