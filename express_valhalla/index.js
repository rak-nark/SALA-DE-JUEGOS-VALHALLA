const express = require("express");
const dotenv = require("dotenv");
const cors = require("cors");

dotenv.config();

const app = express(); // ✅ app creada primero
const PORT = process.env.PORT || 3000;

// Middlewares (después de tener app)
app.use(
  cors({
    origin: "http://localhost:5173", // o '*' para pruebas
  }),
);
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Importar rutas
const authRoutes = require("./src/routes/authRoutes");
const prestamoRoutes = require("./src/routes/prestamoRoutes");
const reservaRoutes = require("./src/routes/reservaRoutes");
const consolaRoutes = require("./src/routes/consolaRoutes");

// Usar rutas
app.use("/api", authRoutes);
app.use("/api", prestamoRoutes);
app.use("/api", reservaRoutes);
app.use("/api/consolas", consolaRoutes);

// Ruta de prueba
app.get("/test-db", async (req, res) => {
  const db = require("./src/config/db");
  try {
    const [rows] = await db.query("SELECT 1+1 AS result");
    res.json({ success: true, data: rows });
  } catch (error) {
    res.status(500).json({ success: false, error: error.message });
  }
});

app.listen(PORT, () => {
  console.log(`⚡ Servidor en http://localhost:${PORT}`);
});
