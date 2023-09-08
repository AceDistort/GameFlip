import './styles/app_game.scss';

document.getElementById('city-select').addEventListener('change', () => {
    let cityId = document.getElementById('city-select').value;
    window.location.href = `?cityId=${cityId}`;
});