<div style="font-family:Arial,sans-serif;max-width:480px;margin:auto;border:1px solid #eee;border-radius:12px;overflow:hidden;">
    <div style="background:#c5005a;padding:20px;text-align:center;">
        <h2 style="color:white;margin:0;">DIVM Educación Especial</h2>
    </div>
    <div style="padding:30px;text-align:center;">
        <p style="font-size:16px;color:#333;">Hola, <strong>{{ $nombre }}</strong></p>
        <p style="color:#555;">Tu código de verificación es:</p>
        <div style="background:#f7f1f5;border:2px dashed #c5005a;border-radius:10px;padding:20px;margin:20px 0;">
            <span style="font-size:40px;font-weight:bold;color:#54063e;letter-spacing:10px;">{{ $codigo }}</span>
        </div>
        <p style="color:#888;font-size:13px;">Este código expira en 10 minutos.</p>
        <p style="color:#aaa;font-size:12px;">Si no fuiste tú, ignora este mensaje.</p>
    </div>
</div>
