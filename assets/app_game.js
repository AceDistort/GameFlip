import './styles/app_game.scss';

const redirectWithFilter = () => {
    let cityId = document.getElementById('city-select').value;
    let available = document.getElementById('available-checkbox').checked;
    console.log(cityId, available);
    window.location.href = `?cityId=${cityId}&available=${available}`;
}

document.getElementById('city-select').addEventListener('change', () => {
    redirectWithFilter();
});

document.getElementById('available-checkbox').addEventListener('change', () => {
    redirectWithFilter();
});