import pkg from 'whatsapp-web.js';
import qrcode from 'qrcode-terminal';
import { Sequelize, DataTypes } from 'sequelize';

const { Client, LocalAuth } = pkg;

const client = new Client({ authStrategy: new LocalAuth() });

// Sequelize setup...
const sequelize = new Sequelize('layerloop', 'root', 'my_sql_naman', {
    host: 'localhost',
    dialect: 'mysql',
    logging: false,
});

const WhatsappMessage = sequelize.define('WhatsappMessage', {
    number: DataTypes.STRING,
    message: DataTypes.TEXT,
    status: DataTypes.ENUM('pending', 'sent', 'failed'),
}, {
    tableName: 'whatsapp_messages',
    timestamps: false
});

// Display QR code in terminal
client.on('qr', qr => {
    qrcode.generate(qr, { small: true }); // <-- properly generate QR
    console.log('Scan the QR code above with WhatsApp');
});

client.on('ready', () => console.log('WhatsApp client ready!'));

// Send pending messages
client.on('ready', () => {
    setInterval(async () => {
        const messages = await WhatsappMessage.findAll({ where: { status: 'pending' } });
        for (const msg of messages) {
            try {
                const chatId = msg.number.includes('@c.us') ? msg.number : `${msg.number}@c.us`;
                await client.sendMessage(chatId, msg.message);
                await msg.update({ status: 'sent' });
                console.log(`Sent message to ${msg.number}`);
            } catch (err) {
                await msg.update({ status: 'failed' });
                console.error(`Failed to send message to ${msg.number}:`, err.message);
            }
        }
    }, 1000);
});

client.initialize();
