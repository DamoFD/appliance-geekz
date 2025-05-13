import Input from '../components/Input';
import { useState, useEffect } from 'react';
import axiosClient from '../axios-client';
import { IoArrowBack } from "react-icons/io5";
import { useNavigate } from 'react-router-dom';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import { Link } from 'react-router-dom';
import BlueSwirl from '/public/images/blue-swirl.webp';
import { AiOutlineLoading3Quarters } from "react-icons/ai";
import {
  FaRegLightbulb,        // idea / electrical issue
  FaTools,               // classic repair tools
  FaScrewdriver,         // direct repair symbol
  FaWrench,              // general fixing
  FaFan,                 // fans, motors
  FaBolt,                // electrical / power
  FaThermometerHalf,     // heating or cooling issue
  FaRegClock,            // timing / cycles
  FaCogs,                // internal mechanisms
} from "react-icons/fa";

import {
  HiOutlineCog,          // config / gear
  HiOutlineLightningBolt // surge / power issue
} from "react-icons/hi";

import {
  TbBoxModel2,           // physical models / dimensions
  TbPlugConnected,       // power connection
  TbTemperature,         // sensors, thermal issues
  TbDropletHalf,         // water sensor / leaks
  TbWashMachine,         // washer-specific
  TbWindmill,            // airflow, ventilation
} from "react-icons/tb";

import {
  VscWand                // diagnostics / magic fix metaphor
} from "react-icons/vsc";

import { FaArrowRight } from "react-icons/fa6";
import { MdSearch } from "react-icons/md";

const Faults = () => {
    const navigate = useNavigate();
    const back = () => {
        navigate(-1);
    }
    const { appliance } = useAppliance();
    const [search, setSearch] = useState('');
    const [filteredFaults, setFilteredFaults] = useState([]);
    const [loading, setLoading] = useState(true);
    const [faults, setFaults] = useState([]);
    const [feedBackVisible, setFeedBackVisible] = useState(false);
    const [aiUsageId, setAiUsageId] = useState('');
    const [feedbackLoading, setFeedbackLoading] = useState(false);

    useEffect(() => {
        getFaults();
    }, []);

    const getFaults = () => {
        setLoading(true);
        axiosClient.get(`/faults/`, {
            params: {
                brand: appliance.brand,
                model: appliance.model,
                serial: appliance.serial
            }
        })
            .then(({data}) => {
                setLoading(false);
                setFaults(data.faults.faults);
                setFilteredFaults(data.faults.faults);
                setFeedBackVisible(true);
                setAiUsageId(data.ai_usage_id);
            })
            .catch((err) => {
                setLoading(false);
                if (err.response.data.error) {
                    alert(err.response.data.error);
                }
                console.error('error fetching faults');
            });
    }

    const sendFeedback = (feedback) => {
        setFeedbackLoading(true);
        axiosClient.post('/feedback', {
            ai_usage_id: aiUsageId,
            feedback: feedback
        })
            .then(({data}) => {
                setFeedBackVisible(false);
            })
            .catch(() => {
                console.error('error sending feedback');
                setFeedBackVisible(false);
            });
    }

    const icons = [
        FaRegLightbulb,        // idea / electrical issue
        FaTools,               // classic repair tools
        FaScrewdriver,         // direct repair symbol
        FaWrench,              // general fixing
        FaFan,                 // fans, motors
        FaBolt,                // electrical / power
        FaThermometerHalf,     // heating or cooling issue
        FaRegClock,            // timing / cycles
        FaCogs,                // internal mechanisms
        HiOutlineCog,          // config / gear
        HiOutlineLightningBolt, // surge / power issue
        TbBoxModel2,           // physical models / dimensions
        TbPlugConnected,       // power connection
        TbTemperature,         // sensors, thermal issues
        TbDropletHalf,         // water sensor / leaks
        TbWashMachine,         // washer-specific
        TbWindmill,            // airflow, ventilation
        VscWand,                // diagnostics / magic fix metaphor
    ];

    const filter = (query) => {
      setSearch(query);

      if (!query) {
        setFilteredFaults(faults);
      } else {
        const q = query.toLowerCase();
        const filtered = faults.filter((fault) =>
          fault.code.toLowerCase().includes(q) ||
          fault.title.toLowerCase().includes(q)
        );
        setFilteredFaults(filtered);
      }
    };

    return (
        <div className="min-h-screen w-full bg-dark-900 p-8 lg:py-12 lg:px-[500px]">
            <IoArrowBack onClick={back} className="text-white size-6 cursor-pointer" />
            <h1
                className="font-inter font-bold text-5xl primary-text-gradient mt-4"
            >
                Common<br />Fault Codes
            </h1>
            <div className="w-full mt-4">
                <Input
                    placeholder="Filter..."
                    EndAdornment={MdSearch}
                    value={search}
                    onChange={(e) => filter(e.target.value)}
                />
            </div>
            {loading ? (
                <div className="w-full flex items-center space-x-2 mt-4">
                    <img src={BlueSwirl} alt="blue swirl" className="w-8" />
                    <AiOutlineLoading3Quarters className="text-white animate-spin" />
                    <p className="font-inter text-secondary">Analyzing manuals... Please wait.</p>
                </div>
            ) : (
                    <div>
                        {filteredFaults.map((fault, index) => {
                            const Icon = icons[index];

                            return (
                                <div className="grid grid-cols-[1fr_3fr] gap-4 text-white mt-8 w-full font-inter" key={index}>
                                    <p className="primary-text-gradient font-bold text-3xl">{fault.code}</p>
                                    <p className="font-bold text-3xl">{fault.title}</p>
                                    <Icon className="size-6 text-[#1796BD]" />
                                    <p className="text-secondary">{fault.solution}</p>
                                    <div />
                                    <Link to={`/app/chat?code=${fault.code}`} className="text-[#1796BD] flex items-center cursor-pointer">
                                        <p className="underline">Chat about this error</p>
                                        <FaArrowRight className="size-4 ml-2" />
                                    </Link>
                                </div>
                            );
                        })}
                    </div>
                )
            }
            {feedBackVisible && (
                <div className="bg-gray-800 p-4 rounded-lg fixed bottom-4 right-4 z-10 flex flex-col items-end space-y-2">
                    <p className="font-inter text-white font-bold cursor-pointer" onClick={() => setFeedBackVisible(false)}>X</p>
                    <p className="font-inter text-white">Was this response helpful?</p>
                    <div className="flex items-center justify-between mt-2 w-full">
                        <button disabled={feedbackLoading} onClick={() => sendFeedback('yes')} className="bg-blue-500 text-white py-2 px-4 rounded-lg">
                            {feedbackLoading ? 'Sending...' : 'Yes'}
                        </button>
                        <button disabled={feedbackLoading} onClick={() => sendFeedback('no')} className="bg-red-500 text-white py-2 px-4 rounded-lg">
                            {feedbackLoading ? 'Sending...' : 'No'}
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}

export default Faults;
