export const consoleOptions = [
  // Xbox Series X (IDs 1 al 4)
  {
    id: 1,
    displayName: "Xbox Series X 1",
    backendName: "Xbox 360 1",
    homeReference: "Xbox Series X",
  },
  {
    id: 2,
    displayName: "Xbox Series X 2",
    backendName: "Xbox 360 2",
    homeReference: "Xbox Series X",
  },
  {
    id: 3,
    displayName: "Xbox Series X 3",
    backendName: "Xbox 360 3",
    homeReference: "Xbox Series X",
  },
  {
    id: 4,
    displayName: "Xbox Series X 4",
    backendName: "Xbox 360 4",
    homeReference: "Xbox Series X",
  },

  // Xbox Series S (IDs 5 al 7)
  {
    id: 5,
    displayName: "Xbox Series S 1",
    backendName: "Xbox 360 5",
    homeReference: "Xbox Series S",
  },
  {
    id: 6,
    displayName: "Xbox Series S 2",
    backendName: "Xbox 360 6",
    homeReference: "Xbox Series S",
  },
  {
    id: 7,
    displayName: "Xbox Series S 3",
    backendName: "Xbox 360 7",
    homeReference: "Xbox Series S",
  },

  // Xbox One (IDs 8 al 10)
  {
    id: 8,
    displayName: "Xbox One 1",
    backendName: "Xbox 360 8",
    homeReference: "Xbox One",
  },
  {
    id: 9,
    displayName: "Xbox One 2",
    backendName: "Xbox One 1",
    homeReference: "Xbox One",
  },
  {
    id: 10,
    displayName: "Xbox One 3",
    backendName: "Xbox One 2",
    homeReference: "Xbox One",
  },

  // Xbox 360 (IDs 11 al 13)
  {
    id: 11,
    displayName: "Xbox 360 1",
    backendName: "Xbox One 3",
    homeReference: "Xbox 360",
  },
  {
    id: 12,
    displayName: "Xbox 360 2",
    backendName: "Xbox One 4",
    homeReference: "Xbox 360",
  },
  {
    id: 13,
    displayName: "Xbox 360 3",
    backendName: "Xbox One 5",
    homeReference: "Xbox 360",
  },
];

export const usageTimeOptions = [
  { label: "30 min", value: 30 },
  { label: "1 hora", value: 60 },
  { label: "1h 30m", value: 90 },
  { label: "2 horas", value: 120 },
  { label: "3 horas", value: 180 },
];

export const buildTimeSlots = () => {
  const slots = [];

  for (let hour = 10; hour <= 20; hour += 1) {
    for (let minute = 0; minute < 60; minute += 30) {
      if (hour === 20 && minute > 0) break;

      const value = `${String(hour).padStart(2, "0")}:${String(minute).padStart(2, "0")}`;
      slots.push({ value, label: value });
    }
  }

  return slots;
};

export const getDateRange = () => {
  const today = new Date();
  const limitDate = new Date();
  limitDate.setDate(today.getDate() + 2);

  return {
    today: today.toISOString().split("T")[0],
    limitDate: limitDate.toISOString().split("T")[0],
  };
};
