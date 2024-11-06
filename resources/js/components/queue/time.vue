<template>
  <div id="clockdate">
    <div class="clockdate-wrapper">
      <div id="clock">{{ currentTime }}</div>
      <div id="date">{{ currentDate }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Time',
  data() {
    return {
      currentTime: '',
      currentDate: ''
    };
  },
  methods: {
    startTime() {
      const today = new Date();
      let hr = today.getHours();
      let min = today.getMinutes();
      let sec = today.getSeconds();
      const ap = (hr < 12) ? "AM" : "PM";
      hr = (hr === 0) ? 12 : hr;
      hr = (hr > 12) ? hr - 12 : hr;

      hr = this.checkTime(hr);
      min = this.checkTime(min);
      sec = this.checkTime(sec);
      this.currentTime = `${hr}:${min}:${sec} ${ap}`;

      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
      const curWeekDay = days[today.getDay()];
      const curDay = today.getDate();
      const curMonth = months[today.getMonth()];
      const curYear = today.getFullYear();
      this.currentDate = `${curWeekDay}, ${curDay} ${curMonth} ${curYear}`;

      setTimeout(this.startTime, 500);
    },
    checkTime(i) {
      return (i < 10) ? "0" + i : i;
    }
  },
  mounted() {
    this.startTime();
  }
};
</script>

<style scoped>
@font-face {
  font-family: 'Digital-7';
  src: url('fonts/digital-7.ttf') format('woff2'),
       url('digital-7.woff') format('woff');
}
.clockdate-wrapper {
 
  padding: 25px;
  max-width: 350px;
  width: 100%;
  text-align: center;
  border-radius: 5px;
  margin: 0 auto;
}
#clock {
  font-family: 'Digital-7', sans-serif;
  font-size: 50px;
  text-shadow: 0px 0px 1px #fff;
  color: #fff;
}
#clock span {
  color: rgba(255, 255, 255, 0.8);
  text-shadow: 0px 0px 1px #333;
  font-size: 50px;
  position: relative;
  top: -5px;
  left: 10px;
}
#date {
  letter-spacing: 3px;
  font-size: 14px;
  font-family: Arial, sans-serif;
  color: #fff;
}
</style>
