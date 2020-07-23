let player;
let playerStatus;
let videoId = false;
let getRandom = document.getElementById('get-random');
let pageTitle = document.getElementById('page-title');
let nextVideo = false;

window.onYouTubeIframeAPIReady = function () {
  player = new YT.Player('player', {
    height: '390',
    width: '640',
    videoId: videoId,
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });

  if (getRandom) {
    loadNext();
  }
}

if (document.getElementById('player')) {
  init();
}

document.addEventListener('click', (evt) => {
  const star = evt.target.closest('.js-star');
  if (!star) {
    return;
  }

  fetch(star.href)
    .then(response => response.json())
    .then(data => {
      setupStar(data.data, star);
    });

  evt.preventDefault();
  return false;
});

function setupStar(data, el) {
  el.href = data.links.star;
  const icon = el.querySelector('.fa-star');

  if (data.star) {
    icon.classList.remove('far');
    icon.classList.add('fa');
    el.classList.remove('btn-outline-secondary');
    el.classList.add('btn-secondary');
  } else {
    icon.classList.remove('fa');
    icon.classList.add('far');
    el.classList.remove('btn-secondary');
    el.classList.add('btn-outline-secondary');
  }
}

function init() {
  videoId = document.getElementById('player').dataset.video;
  if (!videoId) {
    return;
  }

  if (getRandom) {
    getRandom.addEventListener('click', loadNextVideo);
  }
  document.addEventListener('keydown', checkKey);

  const tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  const firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function loadNext() {
  fetch(getRandom.dataset.url)
    .then(response => response.json())
    .then(data => {
      nextVideo = data.data;
      setupNextVideo();
    });
}

function loadNextVideo() {
  if (!nextVideo) {
    return;
  }

  window.history.pushState(nextVideo.id, nextVideo.title, nextVideo.links.url);
  window.document.title = nextVideo.title;
  pageTitle.textContent = nextVideo.title;

  const shareLinks = document.querySelectorAll('.js-share');
  for (let link of shareLinks) {
    link.dataset.title = nextVideo.title;
  }

  const starLinks = document.querySelectorAll('.js-star');
  for (let star of starLinks) {
    setupStar(nextVideo, star);
  }


  player.loadVideoById(nextVideo.video);

  loadNext();
}

function setupNextVideo() {
  const img = document.createElement('img');
  img.src = `https://img.youtube.com/vi/${nextVideo.video}/hqdefault.jpg`;
  img.className = 'img-fluid';
  const strong = document.createElement('strong');
  strong.textContent = `Next up: ${nextVideo.title}`;

  getRandom.innerHTML = '';
  getRandom.appendChild(img);
  getRandom.appendChild(strong);
}

function onPlayerReady(event) {
  event.target.playVideo();
  // console.log(event.target);
}

function onPlayerStateChange(event) {
  playerStatus = event.data;
  if (playerStatus === YT.PlayerState.ENDED) {
    loadNextVideo();
  }
}

function checkKey(event) {
  if (event.code.toLowerCase() === 'keyf') {
    player.f.requestFullscreen();
  }
  if (event.code.toLowerCase() === 'space') {
    if (playerStatus === YT.PlayerState.PLAYING) {
      player.pauseVideo();
    }
    if (playerStatus === YT.PlayerState.PAUSED) {
      player.playVideo();
    }
  }
}
