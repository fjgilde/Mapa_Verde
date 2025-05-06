import dotenv from 'dotenv';
import express from 'express';
import cors from 'cors';
import OpenAI from "openai";

dotenv.config();

const app = express();
const PORT = process.env.PORT || 3000;

const corsOptions = {
  origin: '*',
  methods: ['GET', 'POST', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization'],
  credentials: true
};

app.use(cors(corsOptions));

app.options('*', cors(corsOptions));

const openai = new OpenAI({
  apiKey: process.env.OPENAI_API_KEY
});

app.post('/chat', async (req, res) => {
  try {
    const completion = await openai.chat.completions.create({
      model: "gpt-3.5-turbo",
      messages: req.body.messages,
      temperature: 0.7
    });
    
    res.json({
      content: completion.choices[0].message.content
    });
    
  } catch (error) {
    console.error('Error OpenAI:', error);
    res.status(500).json({ error: error.message });
  }
});

app.use(express.static('public'));

app.listen(PORT, () => {
  console.log(`Servidor funcionando en http://localhost:${PORT}`);
});