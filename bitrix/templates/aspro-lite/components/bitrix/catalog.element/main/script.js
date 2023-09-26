document.addEventListener('DOMContentLoaded', function() {
	const $jsBlocks = document.querySelectorAll('[data-js-block]');

	if ($jsBlocks.length) {
		for (let i = 0; i < $jsBlocks.length; i++) {
			const $container = $jsBlocks[i];
			const $block = $container.dataset.jsBlock
				? document.querySelector($container.dataset.jsBlock)
				: false;
			
			if ($block) {
				$container.appendChild($block);
				$container.removeAttribute(['data-js-block'])
			}
		}
	}

	let props = document.querySelectorAll('.sku-props') 

	props.forEach(prop => {
		prop.addEventListener('click', ()=>{
		
			setTimeout(() => {

			const searchParams = new URLSearchParams(window.location.search);
			const oid = searchParams.get('oid');
			const innerBlock = document.querySelector('.basePrice')
			const priceBlock = document.querySelector('.price.color_222')

			const url = '/ajax/baseprice.php'; 
			const data = {
			oid: oid
			};

			fetch(url, {
				method: 'POST',
				headers: {
				  'Content-Type': 'application/json',
				},
				body: JSON.stringify(data),
			  })
				.then(response => response.json())
				.then(updatedData => {
					innerBlock.innerHTML = updatedData
					priceBlock.insertAdjacentHTML("afterEnd", '<img class="priceInfo lazyloaded" src="/bitrix/templates/aspro-lite/images/svg/question-circle-svgrepo-com.svg" data-src="/bitrix/templates/aspro-lite/images/svg/question-circle-svgrepo-com.svg" width="16" height="16" alt="" title="Ваша цена, как оптовому покупателю">');
				  console.log('Контент успешно заменен:', updatedData.PRICE);
				})
				.catch(error => {
				  console.error(error);
				});
				
			}, 300);
			
		})
		
	});
})


