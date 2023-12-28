interface props {
    str: string;
    num: number;
    optional?: string;
}

const App = (props: props) => {
    const { str, num, optional } = props;
    return (
        <>
            <div>
                <p>react test</p>
            </div>
            <div>
                <p>props:{str}</p>
                <p>props:{num}</p>
                <p>optional:{optional}</p>
            </div>
        </>
    );
};

export default App;
