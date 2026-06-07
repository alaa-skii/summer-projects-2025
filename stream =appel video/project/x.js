let localStream;
let peerConnection;
const config = {
  iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]//stun يرجعلنا ايبي و بورت تاعي انا المرسل في الانترنت باه يقدرو يتصلو معاي الناس ويتفرجوني
};
// الوصول إلى الكاميرا والميكروفون
navigator.mediaDevices.getUserMedia({ video: false, audio: true })
  .then(stream => {
    localStream = stream;
    document.getElementById("localVideo").srcObject = stream;
  });
function sendSignal(data) {
  fetch("send-signal.php", {//fetch() وفيها 2 بارامتر  PHP تستعملها إذا كنت تريد إرسال أو استقبال بيانات من ملف .
    method: "POST",
    body: JSON.stringify(data)
  })
} 

function startCall() {
 
  peerConnection/*هي القناة بين الاجهزة*/  = new RTCPeerConnection(config/* ou {iceServers:[
    {
    urls:'stun:stun.l.gogle.com:19302'=> ytghr wymdlna mital =>stun:stun1....,stun:stun2.... drna msfofa psq ymdna bzf attributs kl w7da fiha ip w port jdd psq ytbdlo dima f internet  
    }
    ] }ping نشئ قناة اتصال مباشرة بين جهازين (مثلاً بينك وبين شخص آخر)، باستخدام الإعدادات الموجودة في */ );

  // إرسال الفيديو والصوت
  localStream.getTracks().forEach(track => {//ou peerconnectio.addStream(localStream)
    peerConnection.addTrack(track, localStream);//fi blast hdo mi tari9a 9dima bzf wmmli7ash 
  });
  

  // استقبال الفيديو من شخص اخر
  peerConnection.ontrack = function(event) {//معناه عندما تحصل على مسار اوديو و فديو الشخص الاخر نفد 
    document.getElementById("remoteVideo").srcObject = event.streams[0];//فيديو لي دارلو شخص تاني بث بش نشوفو//add track pour lenvoi et ontrack pour la reception
  };//streamaudio[0]+streamvideo[0]=streams[0]

  // عند توليد ICE candidates
  peerConnection.onicecandidate = function (event) {//onicecandidate=كلما وجد المتصفح عنوان ايبي  وبورت يصلح للاتصال، أرسلهم للطرف الآخر ليستطيع الاتصال بي ///  معناها: "كلما وجدت ايبي وبورت للاتصال، أعطني إياهم".(IP + port)
    if (event.candidate) {/*//لمنع ظهور الاسطر الحمراء في الكنصول اي نزع قيم null
      : هو عنوان اتصال يتكوّن من candidate

عنوان IP

رقم Port

بروتوكول (UDP أو TCP)

نوع الاتصال (host / srflx / relay)
      */ 
    
      sendSignal( {type: "candidate", candidate: event.candidate}) ;
    }
    
  };

  // إنشاء offer
  peerConnection.createOffer()//أنا أريد الاتصال بك، هذه معلوماتي، هل توافق
    .then(offer => {
      peerConnection.setLocalDescription(offer);
      sendSignal({type:"offer",offer:offer});
    });
}
