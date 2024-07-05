const express = require('express');
const app = express();
const server = require('http').createServer(app);
const cors = require('cors');
const io = require("socket.io")(server, { 
    pingInterval: 25000, // ping 메시지를 보내는 주기 (기본값 25000ms)
    pingTimeout: 60000,  // pong 메시지를 기다리는 시간 (기본값 60000ms)
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

// CORS 미들웨어 사용
app.use(cors());

// Socket.IO 이벤트 핸들링
io.on('connection', (socket) => {
  console.log('새로운 사용자가 연결되었습니다.');

  socket.on('chat message', (msg) => {
    console.log('수신한 메시지:', msg);      
    // 클라이언트들에게 메시지 전송
    io.emit('chat message', msg);
  });
});

const port = 3000;
server.listen(port, () => {
  console.log(`서버가 ${port}번 port에서 실행 중입니다.`);
});
