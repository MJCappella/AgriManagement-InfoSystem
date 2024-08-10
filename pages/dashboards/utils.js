

// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
var _seed = Date.now();

function valueOrDefault(value, defaultValue) {
  return value != null ? value : defaultValue;
}

export function srand(seed) {
  _seed = seed;
}

export function rand(min, max) {
  min = valueOrDefault(min, 0);
  max = valueOrDefault(max, 0);
  _seed = (_seed * 9301 + 49297) % 233280;
  return min + (_seed / 233280) * (max - min);
}

export function numbers(config) {
  var cfg = config || {};
  var min = valueOrDefault(cfg.min, 0);
  var max = valueOrDefault(cfg.max, 100);
  var from = valueOrDefault(cfg.from, []);
  var count = valueOrDefault(cfg.count, 8);
  var decimals = valueOrDefault(cfg.decimals, 8);
  var continuity = valueOrDefault(cfg.continuity, 1);
  var dfactor = Math.pow(10, decimals) || 0;
  var data = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = (from[i] || 0) + this.rand(min, max);
    if (this.rand() <= continuity) {
      data.push(Math.round(dfactor * value) / dfactor);
    } else {
      data.push(null);
    }
  }

  return data;
}

export function points(config) {
  const xs = this.numbers(config);
  const ys = this.numbers(config);
  return xs.map((x, i) => ({x, y: ys[i]}));
}

export function bubbles(config) {
  return this.points(config).map(pt => {
    pt.r = this.rand(config.rmin, config.rmax);
    return pt;
  });
}

export function labels(config) {
  var cfg = config || {};
  var min = cfg.min || 0;
  var max = cfg.max || 100;
  var count = cfg.count || 8;
  var step = (max - min) / count;
  var decimals = cfg.decimals || 8;
  var dfactor = Math.pow(10, decimals) || 0;
  var prefix = cfg.prefix || '';
  var values = [];
  var i;

  for (i = min; i < max; i += step) {
    values.push(prefix + Math.round(dfactor * i) / dfactor);
  }

  return values;
}

const MONTHS = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
];

export function months(config) {
  var cfg = config || {};
  var count = cfg.count || 12;
  var section = cfg.section;
  var values = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = MONTHS[Math.ceil(i) % 12];
    values.push(value.substring(0, section));
  }

  return values;
}

const COLORS = [
  '#4dc9f6',
  '#f67019',
  '#f53794',
  '#537bc4',
  '#acc236',
  '#166a8f',
  '#00a950',
  '#58595b',
  '#8549ba'
];

export function color(index) {
  return COLORS[index % COLORS.length];
}
function parseColor(input) {
  const div = document.createElement('div');
  div.style.color = input;
  document.body.appendChild(div);

  const rgb = window.getComputedStyle(div).color.match(/\d+/g).map(Number);
  document.body.removeChild(div);

  return {
    r: rgb[0],
    g: rgb[1],
    b: rgb[2],
    alpha: 1,
    toRgbString() {
      return `rgb(${this.r}, ${this.g}, ${this.b})`;
    },
    alpha(a) {
      this.alpha = a;
      return this;
    },
    rgbString() {
      return this.alpha === 1
        ? this.toRgbString()
        : `rgba(${this.r}, ${this.g}, ${this.b}, ${this.alpha})`;
    }
  };
}

export function transparentize(value, opacity) {
  const color = parseColor(value);
  const alpha = opacity === undefined ? 0.5 : 1 - opacity;
  return color.alpha(alpha).rgbString();
}


export const CHART_COLORS = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

const NAMED_COLORS = [
  CHART_COLORS.red,
  CHART_COLORS.orange,
  CHART_COLORS.yellow,
  CHART_COLORS.green,
  CHART_COLORS.blue,
  CHART_COLORS.purple,
  CHART_COLORS.grey,
];

export function namedColor(index) {
  return NAMED_COLORS[index % NAMED_COLORS.length];
}

export function newDate(days) {
  return SimpleDateTime.now().plus({days}).toJSDate();
}

export function newDateString(days) {
  return SimpleDateTime.now().plus({days}).toISO();
}

export function parseISODate(str) {
  return SimpleDateTime.fromISO(str);
}
class SimpleDateTime {
  constructor(date = new Date()) {
      this.date = date;
  }

  static now() {
      return new SimpleDateTime(new Date());
  }

  plus({ days = 0 } = {}) {
      const newDate = new Date(this.date);
      newDate.setDate(newDate.getDate() + days);
      return new SimpleDateTime(newDate);
  }

  toJSDate() {
      return this.date;
  }

  toISO() {
      return this.date.toISOString();
  }

  static fromISO(isoString) {
      return new SimpleDateTime(new Date(isoString));
  }
}
export const Utils = {
  srand,
  rand,
  numbers,
  points,
  bubbles,
  labels,
  months,
  color,
  transparentize,
  namedColor,
  newDate,
  newDateString,
  parseISODate,CHART_COLORS
};

// Example usage:
const dt = SimpleDateTime.now().plus({ days: 5 }).toISO();
console.log(dt); // Outputs ISO date string 5 days from now

