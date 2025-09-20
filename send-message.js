import pkg from 'whatsapp-web.js';
const { Client, LocalAuth } = pkg;

const [,, number, message] = process.argv;

const client = new Client({
    authStrategy: new LocalAuth()
});

client.on('ready', async () => {
    const chatId = number.includes('@c.us') ? number : `${number}@c.us`;
    await client.sendMessage(chatId, message);
    console.log('Message sent!');
    process.exit();
});

client.initialize();
