for (let i = 1; i <= 100; i++) {
  if (i % 3 === 0 && i % 5 === 0) {
    console.log('Mari Berkarya');
  } else if (i % 5 === 0) {
    console.log('Berkarya');
  } else if (i % 3 === 0) {
    console.log('Mari');
  } else {
    console.log(i);
  }
}