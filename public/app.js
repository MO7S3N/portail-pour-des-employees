async function jsonFetch(url){
    const response = await fetch(url , {
        headers : {
            Accept : 'application/json'
        }
    })
    if(response.status === 204)
    {
        return null ;
    }
    if(response.ok)
    {
        return await response.json()
    }
    throw response
}




function bindSelect (select)
{
    new TomSelect(select , {
        hideSelected : true ,
        closeAfterSelect : true ,
        load : async (query , callback) => {
            const  url = "${select.dataset.remote}?q=${encodeURIComponent(query)}"
            callback(await jsonFetch(url))
        }
    })
}


Array.from(document.querySelectorAll('select[multiple]')).map(bindSelect)