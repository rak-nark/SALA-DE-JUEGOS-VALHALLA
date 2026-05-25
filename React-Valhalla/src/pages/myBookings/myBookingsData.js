import {
  consoleOptions,
  usageTimeOptions,
} from "../reservation/reservationData";

const bookingDateFormatter = new Intl.DateTimeFormat("es-CO", {
  day: "2-digit",
  month: "short",
  year: "numeric",
});

export const pointsZone = {
  title: "Puntos Valhalla",
  points: 1250,
  description: "Has acumulado puntos para canjearlos por horas gratis.",
};

export const getConsoleDisplayName = (consoleId) => {
  return (
    consoleOptions.find((consoleItem) => consoleItem.id === Number(consoleId))
      ?.displayName ?? `Consola #${consoleId}`
  );
};

export const getUsageTimeLabel = (timeValue) => {
  const numericTime = Number(timeValue);
  const option = usageTimeOptions.find((time) => time.value === numericTime);

  if (option) return option.label;

  const hours = Math.floor(numericTime / 60);
  const minutes = numericTime % 60;
  const parts = [];

  if (hours > 0) parts.push(`${hours} hora${hours > 1 ? "s" : ""}`);
  if (minutes > 0) parts.push(`${minutes} minuto${minutes > 1 ? "s" : ""}`);

  return parts.join(" y ") || "Tiempo no definido";
};

export const formatHour12 = (hour) => {
  if (!hour) return "";

  const [hourPart, minutePart = "00"] = hour.split(":");
  let parsedHour = Number(hourPart);
  const period = parsedHour >= 12 ? "PM" : "AM";

  if (parsedHour > 12) parsedHour -= 12;
  if (parsedHour === 0) parsedHour = 12;

  return `${parsedHour}:${minutePart.padStart(2, "0")} ${period}`;
};

const normalizeDateValue = (dateValue) => {
  if (!dateValue) return null;

  if (dateValue instanceof Date) {
    return Number.isNaN(dateValue.getTime()) ? null : dateValue;
  }

  const directDate = new Date(dateValue);
  if (!Number.isNaN(directDate.getTime())) {
    return directDate;
  }

  if (typeof dateValue === "string") {
    const plainDate = new Date(`${dateValue.slice(0, 10)}T00:00:00`);
    return Number.isNaN(plainDate.getTime()) ? null : plainDate;
  }

  return null;
};

export const formatDate = (dateValue) => {
  const date = normalizeDateValue(dateValue);

  if (!date) return "Fecha no definida";

  return bookingDateFormatter.format(date);
};

export const isUpcomingBooking = (booking) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const bookingDate = normalizeDateValue(booking.fecha);

  if (!bookingDate) return false;

  return bookingDate >= today;
};
