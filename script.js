// ダミー早見表ロジック。後でDB/APIで置き換え可
function calcSimulation(area, units, age) {
    // 仮の計算式
    // 基本単価（例）
    const baseMng = 700;      // 管理費 1㎡あたり/年
    const baseRepair = 600;   // 修繕積立金 1㎡あたり/年

    // 築年数で掛け率変更
    let ageRate = 1.0;
    if (age < 10) ageRate = 0.85;
    else if (age < 20) ageRate = 1.00;
    else if (age < 30) ageRate = 1.08;
    else ageRate = 1.13;

    // 戸数ボーナス
    let unitRate = 1.0;
    if (units >= 150) unitRate = 0.92;  // 大規模割引
    else if (units <= 20) unitRate = 1.14; // 小規模割増

    // 年間計算
    const annualMng = Math.round(area * baseMng * units * ageRate * unitRate / units); // 全体で計算→1戸あたり
    const annualRepair = Math.round(area * baseRepair * units * ageRate * unitRate / units);
    const annualTotal = annualMng + annualRepair;

    // 月間
    const monthlyMng = Math.round(annualMng / 12);
    const monthlyRepair = Math.round(annualRepair / 12);
    const monthlyTotal = Math.round(annualTotal / 12);

    return {
        annualMng, annualRepair, annualTotal,
        monthlyMng, monthlyRepair, monthlyTotal
    };
}

// フォーム操作
document.getElementById('simForm').addEventListener('submit', function(e){
    e.preventDefault();
    const area = Number(document.getElementById('area').value);
    const units = Number(document.getElementById('units').value);
    const age = Number(document.getElementById('age').value);

    const r = calcSimulation(area, units, age);

    // 表示
    document.getElementById('annual-fee').textContent = r.annualMng.toLocaleString();
    document.getElementById('annual-repair').textContent = r.annualRepair.toLocaleString();
    document.getElementById('annual-total').textContent = r.annualTotal.toLocaleString();
    document.getElementById('monthly-fee').textContent = r.monthlyMng.toLocaleString();
    document.getElementById('monthly-repair').textContent = r.monthlyRepair.toLocaleString();
    document.getElementById('monthly-total').textContent = r.monthlyTotal.toLocaleString();

    document.getElementById('result').style.display = 'block';
});
